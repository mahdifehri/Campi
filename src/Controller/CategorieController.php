<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Produit;
use App\Form\CategorieType;
use App\Form\ProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    /**
     * @Route("categorie/{id}/show", name="categorie_show")
     * @param Categorie $categorie
     * @return Response
     */
    public function show(Categorie $categorie): Response
    {
        return $this->render("categorie/show.html.twig", [
            "categorie" => $categorie
        ]);
    }
    /**
     * @Route("categorie/add", name="categorie_add")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('home');

        }
        return $this->render('categorie/add.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("categorie/{id}/edit", name="categorie_edit")
     * @param Categorie $categorie
     * @param Request $request
     * @return Response
     */
    public function edit(Categorie $categorie, Request $request): Response
    {
        $form = $this->createForm(CategorieType::class,$categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('home');
        }
        return $this->render("categorie/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("categorie/{id}/delete", name="categorie_delete")
     * @param Categorie $categorie
     * @return RedirectResponse
     */
    public function delete(Categorie $categorie): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();

        return $this->redirectToRoute("home");
    }
}
