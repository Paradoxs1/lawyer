<?php

namespace App\Controller;

use App\Form\LoginFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginFormType::class, [
            '_username' => $lastUsername,
        ]);

        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
            'error'         => $error,
            ]);
    }

    /**
     * @Route("/logout", name="logout")
     * @throws \Exception
     */
    public function logout()
    {
        throw new \Exception('this should not be reached!');
    }
}
