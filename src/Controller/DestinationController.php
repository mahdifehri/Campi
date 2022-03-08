<?php

namespace App\Controller;

use App\Entity\Destination;
use App\Entity\Reclamation;
use App\Form\DestinationType;
use App\Form\ReclamationType;
use App\Repository\DestinationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DestinationController extends AbstractController
{
    /**
     * @Route("back/destination/new", name="destination_new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $destination = new Destination();
        $form = $this->createForm(DestinationType::class,$destination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($destination);
                $entityManager->flush();
               return $this->redirectToRoute('destination');

            }

        return $this->render('back/destination/new.html.twig', [
            'destination' => $destination,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("back/destination", name="destination")
     * @param DestinationRepository $destinationRepository
     */
    public function affiche(DestinationRepository $destinationRepository): Response
    {
        return $this->render('back/destination/affiche.html.twig',[
            "destinations"=>  $destinationRepository->findAll()
        ]);
    }


    /**
     * @Route("back/destination/{id}/delete", name="destination_delete")
     * @param Request $request
     */
    public function delete(Request $request, Destination $destination): Response
    {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($destination);
            $entityManager->flush();

        return $this->redirectToRoute('destination');
    }
    /**
     * @Route("back/destination/{id}/edit", name="destination_edit")
     * @param Destination $destination
     * @param Request $request
     * @return Response
     */
    public function edit (Destination $destination,Request $request): Response
    {
        $form = $this->createForm(DestinationType::class,$destination);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("destination");
        }
        return $this->render("back/destination/edit.html.twig",[
            "form"=>$form->createView()
        ]);
    }
    /**
     * @Route("/{id}", name="destination_show", methods={"GET", "POST"})
     */
    public function show(Request $request, Destination $destination): Response
    {
        $reclamation = new Reclamation();
        $reclamation->setDestination($destination);
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('destination_show', ['id' => $destination->getId()]);
        }

        return $this->render('front/destination/show.html.twig', [
            'destination' => $destination,
            'form' => $form->createView(),
        ]);
    }
}

