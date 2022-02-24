<?php

namespace App\Controller;

use App\Entity\Destination;
use App\Form\DestinationType;
use App\Repository\DestinationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DestinationController extends AbstractController
{
    /**
     * @Route("/destination/new", name="destination_new")
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

        return $this->render('destination/new.html.twig', [
            'destination' => $destination,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/destination", name="destination")
     * @param DestinationRepository $destinationRepository
     */
    public function affiche(DestinationRepository $destinationRepository): Response
    {
        return $this->render('destination/affiche.html.twig',[
            "destinations"=>  $destinationRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="destination_show", methods={"GET"})
     */
    public function edit(Request $request, destination $destination): Response
    {
        $form = $this->createForm(DestinationType::class, $destination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('destination_index');
        }

        return $this->render('destination/edit.html.twig', [
            'destination' => $destination,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("destination/{id}/delete", name="destination_delete")
     * @param Request $request
     */
    public function delete(Request $request, Destination $destination): Response
    {
        if ($this->isCsrfTokenValid('delete'.$destination->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($destination);
            $entityManager->flush();
        }

        return $this->redirectToRoute('destination');
    }
}

