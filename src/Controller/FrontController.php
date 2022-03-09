<?php

namespace App\Controller;

use App\Data\SearchData;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;

class FrontController extends AbstractController
{
    /**
     * @Route("/front", name="front")
     */
    public function index(ProduitRepository $produitRepository,Request $request): Response
    {
        $data = new SearchData();
        $form = $this->createForm(\App\Form\SearchType::class,$data);
        $form->handleRequest($request);
        $produit=$produitRepository->findSearch($data);
        return $this->render('base-front.html.twig', [
            'produits' => $produit,
            'form'=> $form->createView()
        ]);
    }
}
