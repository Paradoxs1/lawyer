<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResettingFormType;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResettingController extends AbstractController
{

    /**
     * @Route("/request", name="request")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param UserService $userService
     * @param EntityManagerInterface $em
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function request(Request $request, UserRepository $userRepository, UserService $userService, EntityManagerInterface $em)
    {
        $email = $request->get('email');
        $error = '';

        if (!is_null($email) && $request->isMethod('POST')) {
            $user = $userRepository->findOneBy(['email' => $email]);

            if ($user) {
                $userService->sendRegistrationEmail($user, 'resetting', 'Resetting', 'emails/reset.html.twig');

                $date = new \DateTime();
                $user->setUpdatedAt($date->modify('+1 hour'));
                $em->flush();

                return $this->render('resetting/checkEmail.html.twig', ['user' => $user]);
            }

            $error = 'This account does not exist';
        }

        return $this->render('resetting/request.html.twig', ['error' => $error]);
    }

    /**
     * @Route("/resetting/{confirmationToken}", name="resetting")
     * @param string $confirmationToken
     * @param User $user
     * @param EntityManagerInterface $em
     * @param Request $request
     * @param TokenStorageInterface $tokenStorage
     * @param UserPasswordEncoderInterface $encoder
     *
     * @return Response
     * @ParamConverter("user", options={"mapping": {"confirmationToken": "confirmationToken"}})
     */
    public function resetting(string $confirmationToken, User $user, EntityManagerInterface $em, Request $request, TokenStorageInterface $tokenStorage, UserPasswordEncoderInterface $encoder)
    {
        if (!$confirmationToken){
            throw $this->createNotFoundException();
        }

        if (!$user || $user->getUpdatedAt() < new \DateTime()) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(ResettingFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($user, $form->get('plainPassword')->getData());

            $user->setPassword($encoded);
            $user->setConfirmationToken(md5(uniqid()));
            $em->flush();

            $token = new UsernamePasswordToken(
                $user,
                $user->getPassword(),
                'main',
                $user->getRoles()
            );

            $tokenStorage->setToken($token);

            return $this->render('main/index.html.twig');
        }

        return $this->render('resetting/reset.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
