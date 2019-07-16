<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\Feedback;
use App\Form\FeedbackType;
use App\Repository\DocumentRepository;
use App\Repository\PartnerRepository;
use App\Repository\PostRepository;
use App\Service\FeedbackService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     * @param PostRepository $postRepository
     *
     * @return Response
     */
    public function index(PostRepository $postRepository)
    {
        $lastPosts = $postRepository->getLastPosts(Post::LIMIT_FOR_MAIN_PAGE);

        return $this->render('main/index.html.twig', [
            'lastPosts' => $lastPosts
        ]);
    }

    /**
     * @return Response
     */
    public function createFeedbackForm()
    {
        $feedbackForm = $this->createForm(FeedbackType::class, new Feedback());

        return $this->render('popup/callback.html.twig', [
            'feedbackForm' => $feedbackForm->createView()
        ]);
    }

    /**
     * @Route("/feedback", name="feedback")
     * @param Request $request
     * @param FeedbackService $feedbackService
     *
     * @return Response
     */
    public function saveFeedback(Request $request, FeedbackService $feedbackService)
    {
        $result = $feedbackService->saveFeedback($request);

        if ($result === 'success') {
            return $this->redirectToRoute('homepage');
        }

        return $this->render('popup/callback.html.twig', $result);
    }

    /**
     * @Route("/documents", name="documents")
     * @param DocumentRepository $documentRepository
     *
     * @return Response
     */
    public function getDocuments(DocumentRepository $documentRepository)
    {
        $lastDocuments = $documentRepository->getLastDocuments(Document::LIMIT_FOR_PAGE);

        return $this->render('main/document.html.twig', [
            'lastDocuments' => $lastDocuments
        ]);
    }

    /**
     * @Route("/partners", name="partners")
     * @param PartnerRepository $partnerRepository
     *
     * @return Response
     */
    public function getPartners(PartnerRepository $partnerRepository)
    {
        $partners = $partnerRepository->findAll();

        return $this->render('main/partner.html.twig', [
            'partners' => $partners
        ]);
    }
}
