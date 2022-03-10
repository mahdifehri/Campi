<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Post;
use App\Form\CommentaireType;
use App\Form\PostType;
use App\Repository\CommentaireRepository;
use App\Repository\PostRepository;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Snipe\BanBuilder\CensorWords;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{

    /**
     * @Route("/", name="post_index")
     */
    public function index(PostRepository $postRepository ): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findBy(["etat"=>1],['nbr_reaction' => 'DESC']),
        ]);
    }
    /**
     * @Route("/{id}/addReact", name="post_addReact")
     */
    public function addReact(Post $post): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $post->setNbrReaction(($post->getNbrReaction())+1);
        $em->flush();
        return $this->redirectToRoute("post_index");

    }


    /**
     * @Route("/mespostes", name="mes_postes")
     * @param Request $request
     * @param PostRepository $postRepository
     * @return Response
     */
    public function new(Request $request, PostRepository $postRepository, CommentaireRepository $commentaireRepository): Response
    {
        $post = new Post();
        $post->setIdUser(1);
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/mespostes.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
            'posts' => $postRepository->findAll(),
            'commentaires'=>$commentaireRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="post_show")
     * @param Post $post
     * @param CommentaireRepository $commentaireRepository
     * @param Request $request
     * @return Response
     */
    public function show(Post $post , CommentaireRepository $commentaireRepository, Request $request, FlashyNotifier $flashyNotifier): Response
    {
        $commentaire = new Commentaire();
        $censor = new CensorWords;
        $form=$this->createForm(CommentaireType::class , $commentaire);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $contenu =$form->getData()->getContenu();
            $censor = new CensorWords;
            $badwords= $censor->setDictionary('fr');
            $string = $censor->censorString($contenu);
            $commentaire->setContenu($string['clean']);
            $commentaire->setPosts($post);
            $commentaire->setIdUser(1);
            $commentaire->setIdPost(1);
            $em=$this->getDoctrine()->getManager();
            $em->persist($commentaire);
            $flashyNotifier->success('Vous avez un nouveau commentaire!', 'https://your-awesome-link.com');
            $post->setNbrCommentaire(($post->getNbrCommentaire())+1);
            $em->flush();
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
            "form"=>$form->createView(),
            "commentaires"=>$commentaireRepository->findBy(["posts"=>$post]),
        ]);
    }
    /**
     * @Route("/edit/{id}", name="post_edit")
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}/deletePost", name="post_delete")

     */
    public function delete(Request $request, Post $post): Response
    {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();


        return $this->redirectToRoute('mes_postes');

    }
    /**
     * @Route("/{id}/delete", name="commentaire_delete")

     */
    public function delete_com(Request $request, Commentaire $commentaire): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($commentaire);
        $entityManager->flush();


        return $this->redirectToRoute('mes_postes');
    }
}
