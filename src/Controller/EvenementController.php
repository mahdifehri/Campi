<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Participant;
use App\Form\EvenementType;
use App\Form\ParticipantType;
use App\Repository\EvenementRepository;
use App\Repository\ParticipantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement", name="evenement")
     * @param EvenementRepository $evenementRepository
     * @return Response
     */
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/index.html.twig',[
          "evenements"=>  $evenementRepository->findBy(["etat" =>1])
        ]);
    }

    /**
     * @Route("/mesevenements", name="mesevenements")
     * @param Request $request
     * @param EvenementRepository $evenementRepository
     * @return Response
     */
    public function mesevenements(Request $request,EvenementRepository $evenementRepository): Response
    {
        $evenement = new Evenement();
        $form= $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em =$this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
        }
        return $this->render('evenement/mesevenements.html.twig', [
            "form"=>$form->createView(),
            "evenements"=>  $evenementRepository->findAll()
        ]);
    }
    /**
     * @Route("evenement/{id}/show", name="evenement_show")
     * @param Evenement $evenement
     * @return Response
     */
    public function show (Evenement $evenement,ParticipantRepository $participantRepository,Request $request): Response
    {
        $participant = new Participant();
        $form= $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);
        $participant->setEvenements($evenement);
        $participant->setIdUser(1);
        if($form->isSubmitted() && $form->isValid())
        {
            $em =$this->getDoctrine()->getManager();
            $em->persist($participant);
            $em->flush();
        }
        return $this->render("evenement/show.html.twig",[
         "evenement"=>$evenement,
            "formparticipant"=>$form->createView(),
            "participants"=>$participantRepository->findAll()
        ]);
    }


    /**
     * @Route("evenement/{id}/delete", name="evenement_delete")
     * @param Evenement $evenement
     * @return RedirectResponse
     */
    public function delete (Evenement $evenement): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute("mesevenements");
    }

    /**
     * @Route("evenement/{id}/edit", name="evenement_edit")
     * @param Evenement $evenement
     * @param Request $request
     * @return Response
     */
    public function edit (Evenement $evenement,Request $request): Response
    {
        $form = $this->createForm(EvenementType::class,$evenement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("mesevenements");
        }
        return $this->render("evenement/edit.html.twig",[
            "form"=>$form->createView()
        ]);
    }
}
