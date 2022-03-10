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
     * @Route("/front_prod", name="front_prod")
     */
    public function index(ProduitRepository $produitRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $data = new SearchData();

        $form = $this->createForm(\App\Form\SearchType::class,$data);
        $form->handleRequest($request);
        $produit=$produitRepository->findSearch($data,$paginator);
        return $this->render('base-front.html.twig', [
            'paginator' => true,
            'produits' => $paginator->paginate(
                $produit,
                $request->query->getInt('page', 1),
                2
            ),
            'form'=> $form->createView()
        ]);
    }
    /**
     * @Route("front_prod/detail/{id}", name="produit_detail")
     */
    public function detailP(Produit $produit): Response
    {

        return $this->render('produit/detailsprod.html.twig', [
            'produit' => $produit,
        ]);
    }
}
