<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/listeProduits.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }
    /**
     * @Route("produit/add", name="produit_add")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($produit->getImage()== "")
                $produit->setImage("no_image.jpg");
            else{
                $file=new File($produit->getImage());
                $fileName=md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'),$fileName);
                $produit->setImage($fileName);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('front');

        }
        return $this->render('produit/add.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("produit/{id}/show", name="article_show")
     * @param Produit $produit
     * @return Response
     */
    public function show(Produit $produit): Response
    {
        return $this->render("produit/show.html.twig", [
            "produit" => $produit
        ]);
    }

    /**
     * @Route("produit/{id}/edit", name="produit_edit")
     * @param Produit $produit
     * @param Request $request
     * @return Response
     */
    public function edit(Produit $produit, Request $request): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('home');
        }
        return $this->render("produit/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("produit/{id}/delete", name="produit_delete")
     * @param Produit $produit
     * @return RedirectResponse
     */
    public function delete(Produit $produit): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();

        return $this->redirectToRoute("home");
    }
}
