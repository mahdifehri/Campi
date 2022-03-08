<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Participant;
use App\Entity\User;
use App\Form\EvenementType;
use App\Form\ParticipantType;
use App\Repository\EvenementRepository;
use App\Repository\ParticipantRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement", name="evenement")
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     */
    public function index(Request $request,PaginatorInterface $paginator): Response
    {
        $em=$this->getDoctrine()->getManager();
        $evenement = $em->getRepository(Evenement::class)->findBy(["etat" =>1]);
        $evenement = $paginator->paginate(
            $evenement,
            $request->query->getInt('page',1),
            4
        );
        if($request->isMethod("POST"))
        {
            $destination=$request->get('destination');
            $evenement= $em->getRepository(Evenement::class)->findBy(["destination"=>$destination,"etat"=>1]);


        }
        return $this->render('evenement/index.html.twig',[
          "evenements"=>  $evenement
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
        $iduser=1;
        $evenement = new Evenement();
        $form= $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {  $em=$this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneBy(["id"=>$iduser]);
            $evenement->setUsers($user);
            $em =$this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
        }

        return $this->render('evenement/mesevenements.html.twig', [
            "form"=>$form->createView(),
            "evenements"=>  $evenementRepository->findBy(["users"=>$iduser]),
        ]);
    }


    /**
     * @Route("evenement/{id}/show", name="evenement_show")
     * @param Evenement $evenement
     * @param ParticipantRepository $participantRepository
     * @param Request $request
     * @return Response
     */
    public function show (Evenement $evenement,ParticipantRepository $participantRepository,Request $request): Response
    {   $iduser=1;
        $participant = new Participant();
        $em=$this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(["id"=>$iduser]);
        $form= $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);
        $participant->setUsers($user);
        $participant->setEvenements($evenement);
        if($form->isSubmitted() && $form->isValid())
        {
            $evenement->setNbrParticipants(($evenement->getNbrParticipants())+1);
            $em =$this->getDoctrine()->getManager();
            $em->persist($participant);
            $em->flush();

        }
        return $this->render("evenement/show.html.twig",[
         "evenement"=>$evenement,
            "formparticipant"=>$form->createView(),
            "participants"=>$participantRepository->findAll(),
            "user"=>$user
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
    /**
     * @Route("evenement/calendrier", name="calendrier")
     */
    public function calendrier (EvenementRepository $evenement)
    { $events = $evenement->findAll();
        $rdvs = [];
        foreach ($events as $event){
            $rdvs[] = [
                'id' => $event->getId(),
                'start' => $event->getDate()->format('Y-m-d'),
                'end' => $event->getDate()->format('Y-m-d'),
                'title' => $event->getDestination(),
                'description'=>$event->getDescription(),
                'backgroundColor'=>'#27ae60',
                'borderColor'=>'#ffffff',
                'textColor'=>'#ffffff',

            ];
        }
        $data = json_encode($rdvs);
        return $this->render("evenement/calendar.html.twig",compact('data'));
    }

}
