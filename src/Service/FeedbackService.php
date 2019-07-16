<?php

namespace App\Service;

use App\Entity\Feedback;
use App\Form\FeedbackType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class FeedbackService
{
    private $entityManager;

    private $formFactory;

    /**
     * FeedbackService constructor.
     * @param EntityManagerInterface $entityManager
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(EntityManagerInterface $entityManager, FormFactoryInterface $formFactory) {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
    }

    /**
     * @param Request $request
     *
     * @return array|string
     */
    public function saveFeedBack(Request $request)
    {
        $form = $this->formFactory->create(FeedbackType::class, new Feedback());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $feedBack = $form->getData();

            //add feedback to DB
            $this->entityManager->persist($feedBack);
            $this->entityManager->flush();

            return 'success';
        }

        return [
            'form' => $form->createView()
        ];
    }
}
