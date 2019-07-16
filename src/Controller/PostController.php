<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PostController extends AbstractController
{
    /**
     * @Route("/news", name="allNews")
     * @param PostRepository $postRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     *
     * @return Response
     */
    public function getAllNews(PostRepository $postRepository, PaginatorInterface $paginator, Request $request) {
        $queryLastPosts = $postRepository->getQueryLastPosts();

        $lastPosts = $paginator->paginate(
            $queryLastPosts,
            $request->query->getInt('page', 1),
            Post::LIMIT_FOR_NEWS_PAGE
        );

        return $this->render('post/posts.html.twig', [
            'lastPosts' => $lastPosts
        ]);
    }

    /**
     * @Route("/news/{slug}", name="singleNews")
     * @param Post $post
     * @param PostRepository $postRepository
     * @ParamConverter("post", options={"mapping": {"slug": "slug"}})
     *
     * @return Response
     */
    public function getSingleNews(Post $post, PostRepository $postRepository)
    {
        $lastPosts = $postRepository->getLastPosts(Post::LIMIT_FOR_SINGLE_PAGE);
        $countPosts = $postRepository->getCountPosts();

        return $this->render('post/single-post.html.twig', [
            'singlePost' => $post,
            'lastPosts' => $lastPosts,
            'countPosts' => $countPosts
        ]);
    }
}
