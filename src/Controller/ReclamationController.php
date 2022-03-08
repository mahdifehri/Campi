<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReclamationController extends AbstractController

{

    /**
     * @Route("back/reclamation", name="reclamation")
     * @param ReclamationRepository $reclamationRepository
     */
    public function affiche(ReclamationRepository $reclamationRepository): Response
    {
        return $this->render('back/reclamation/affiche.html.twig',[
            "reclamations"=>  $reclamationRepository->findAll()
        ]);
    }


    /**
     * @Route("back/reclamations/{id}/delete", name="reclamation_delete")
     * @param Request $request
     */
    public function delete(Request $request, Reclamation $reclamation): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($reclamation);
        $entityManager->flush();

        return $this->redirectToRoute('reclamation');
    }
    /**
     * @Route("back/reclamation/{id}/edit", name="reclamation_edit")
     * @param Reclamation $reclamation
     * @param Request $request
     * @return Response
     */
    public function edit (Reclamation $reclamation,Request $request): Response
    {
        $form = $this->createForm(ReclamationType::class,$reclamation);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("reclamation");
        }
        return $this->render("back/reclamation/edit.html.twig",[
            "form"=>$form->createView()
        ]);
    }
}
