<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Form\PostType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class BackPostController extends AbstractController
{
    /**
     * @Route("/back/post", name="back_post")
     * @param PostRepository $postRepository
     * @return Response
     */

    public function index(PostRepository $postRepository): Response
    {
        return $this->render('back_post/index.html.twig',[
            "posts"=>  $postRepository->findAll()
        ]);
    }
    /**
     * @Route("back/post/{id}/valide", name="backpost_valide")
     * @param Post $post
     * @return RedirectResponse
     */
    public function valide (Post $post): RedirectResponse
    {   $post->setEtat(1);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute("back_post");
    }
    /**
     * @Route("back/post/{id}/refuse", name="backpost_refuse")
     * @param Post $post
     * @return RedirectResponse
     */
    public function refuse (Post $post): RedirectResponse
    {   $post->setEtat(2);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute("back_post");
    }
}
