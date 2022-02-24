<?php

namespace App\Controller;


use App\Entity\Participant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantController extends AbstractController
{
    /**
     * @Route("/participant", name="participant")
     */
    public function index(): Response
    {
        return $this->render('participant/index.html.twig', [
            'controller_name' => 'ParticipantController',
        ]);
    }
    /**
     * @Route("/participant/{id}/delete", name="participant_delete")
     * @param Participant $participant
     * @return RedirectResponse
     */
    public function delete (Participant $participant): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $iddd = $participant->getEvenements()->getId();
        $em->remove($participant);
        $em->flush();
        return $this->redirectToRoute('evenement_show', ['id' => $iddd]);
    }
}
