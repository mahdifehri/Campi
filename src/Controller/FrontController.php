<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('base-front.html.twig', [
            'controller_name' => 'FrontController',
            'produits' => $produitRepository->findAll(),
        ]);
    }
}
