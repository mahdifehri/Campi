<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontCommandeController extends AbstractController
{
    /**
     * @Route("/front", name="front_commande" , methods={"GET"})
     */
    public function index(CommandeRepository $commandeRepositry): Response
    {
        return $this->render('front_commande/index.html.twig', [

            'com_reps'=>$commandeRepositry->findAll(),
        ]);
    }
}
