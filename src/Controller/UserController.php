<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationLawyerFormType;
use App\Form\RegistrationUserFormType;
use App\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @param UserService $userService
     * @return Response
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function register(Request $request, UserService $userService)
    {
        $formLawyer = $this->createForm(RegistrationLawyerFormType::class);
        $formUser = $this->createForm(RegistrationUserFormType::class);

        $userLawyer = $userService->formValid($formLawyer, $request);
        $user = $userService->formValid($formUser, $request);

        if ($userLawyer || $user) {
            if (!empty($userLawyer)) {
                $user = $userLawyer;
            }

            return $this->render('registration/checkEmail.html.twig', ['user' => $user]);

        }

        $checkUserFormRegistrationTab = false;

        if ($formUser->getErrors(true)->getChildren()) {
            $checkUserFormRegistrationTab = true;
        }

        return $this->render('registration/registration.html.twig', [
            'formLawyer' => $formLawyer->createView(),
            'formUser'   => $formUser->createView(),
            'checkTab'   => $checkUserFormRegistrationTab
        ]);

    }

    /**
     * @Route("/check-email/{confirmationToken}", name="checkEmail")
     * @param string $confirmationToken
     * @param User $user
     * @param EntityManagerInterface $em
     * @param TokenStorageInterface $tokenStorage
     *
     * @return Response
     * @ParamConverter("user", options={"mapping": {"confirmationToken": "confirmationToken"}})
     */
    public function checkEmail(string $confirmationToken, User $user, EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        if (!$confirmationToken){
            throw $this->createNotFoundException();
        }

        if ($user) {
            $user->setEnable(true);
            $user->setConfirmationToken(md5(uniqid()));
            $user->setUpdatedAt(new \DateTime());
            $em->flush();

            $token = new UsernamePasswordToken(
                $user,
                $user->getPassword(),
                'main',
                $user->getRoles()
            );

            $tokenStorage->setToken($token);
        }

        return $this->render('registration/confirmation.html.twig', ['user' => $user]);
    }

}
