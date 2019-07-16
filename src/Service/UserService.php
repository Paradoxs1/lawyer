<?php

namespace App\Service;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class UserService
{

    private $em;

    private $router;

    private $container;

    private $mailer;

    private $directory;

    /**
     * UserService constructor.
     * @param EntityManagerInterface $em
     * @param RouterInterface $router
     * @param ContainerInterface $container
     * @param \Swift_Mailer $mailer
     * @param string $directory
     */
    public function __construct(EntityManagerInterface $em, RouterInterface $router, ContainerInterface $container, \Swift_Mailer $mailer, string $directory)
    {
        $this->em = $em;
        $this->router = $router;
        $this->container = $container;
        $this->mailer = $mailer;
        $this->directory = $directory;
    }

    /**
     * @param FormInterface $form
     * @param Request $request
     * @return User|bool
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function formValid(FormInterface $form, Request $request)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var User $user */
            $user = $form->getData();

            $user->setConfirmationToken(md5(uniqid()));

            if ($user->getNumberCertificate() || $user->getOrganization()) {
                $user->setRoles(['ROLE_LAWYER']);
            }

            /** @var UploadedFile $file */
            $file = $form->get('avatar')->getData();

            if (!empty($file)) {
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

                $file->move(
                    $this->directory,
                    $fileName
                );

                $user->setAvatar($fileName);
            }

            $this->em->persist($user);
            $this->em->flush();

            $this->sendRegistrationEmail($user, 'checkEmail', 'Registration', 'emails/registration.html.twig');

            return $user;
        }

        return false;
    }

    /**
     * @param User $user
     * @param $routerName
     * @param $name
     * @param $twig
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendRegistrationEmail(User $user, $routerName, $name, $twig)
    {
        $url = $this->router->generate($routerName, ['confirmationToken' => $user->getConfirmationToken()], UrlGeneratorInterface::ABSOLUTE_URL);

        $message = (new \Swift_Message($name))
            ->setFrom(getenv('MAIN_EMAIL'))
            ->setTo($user->getEmail())
            ->setBody($this->container->get('twig')->render($twig,
                    ['username' => $user->getUsername(), 'url' => $url]),
                'text/html');

        $this->mailer->send($message);
    }

    /**
     * @return string
     */
    private function generateUniqueFileName(): string
    {
        return md5(uniqid());
    }

}