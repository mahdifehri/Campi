<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackEvenementController extends AbstractController
{
    /**
     * @Route("/back/evenement", name="back_evenement")
     * @param EvenementRepository $evenementRepository
     * @return Response
     */

    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('back_evenement/index.html.twig',[
            "evenements"=>  $evenementRepository->findAll()
        ]);
    }
    /**
     * @Route("back/evenement/{id}/valide", name="backevenement_valide")
     * @param Evenement $evenement
     * @return RedirectResponse
     */
    public function valide (Evenement $evenement): RedirectResponse
    {   $evenement->setEtat(1);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute("back_evenement");
    }
    /**
     * @Route("back/evenement/{id}/refuse", name="backevenement_refuse")
     * @param Evenement $evenement
     * @return RedirectResponse
     */
    public function refuse (Evenement $evenement): RedirectResponse
    {   $evenement->setEtat(2);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute("back_evenement");
    }
}
