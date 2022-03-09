<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Entity\Destination;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use App\Service\PDFService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\File\File;

class ReclamationController extends AbstractController

{

    /**
     * @Route("front/reclamation/new", name="reclamation_new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class,$reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($reclamation->getFile()=="")
                $reclamation->setFile("no_image.jpg");
            else
            {
                $file = new File($reclamation->getFile());
                $fileName= md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'),$fileName);
                $reclamation->setFile($fileName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reclamation);
            $entityManager->flush();
            return $this->redirectToRoute('reclamation_new');

        }

        return $this->render('front/reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }
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
    /**
     * @Route("back/reclamation/{id}", name="reclamation_show_back", methods={"GET"})
     */
    public function showb(Reclamation $reclamation): Response
    {
        return $this->render('back/reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }
    /**
     * @Route("front/reclamation/{id}", name="reclamation_show", methods={"GET"})
     */
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('front/reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }
    /**
     * @Route("back/reclamation/{id}/valide", name="reclamation_valide")
     * @param Reclamation $reclamation
     * @return RedirectResponse
     */
    public function valide (Reclamation $reclamation): RedirectResponse
    {   $reclamation->setEtatRec("Treated");
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $idd = $reclamation->getIdRec();
        return $this->redirectToRoute("reclamation_show_back",[
            'id' => $idd
        ]);
    }
    /**
     * @Route("back/reclamation/{id}/novalide", name="reclamation_novalide")
     * @param Reclamation $reclamation
     * @return RedirectResponse
     */
    public function refuse (Reclamation $reclamation): RedirectResponse
    {   $reclamation->setEtatRec("InValide");
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $idd = $reclamation->getIdRec();
        return $this->redirectToRoute("reclamation_show_back",[
            'id' => $idd
        ]);
    }
    /**
     * @Route("back/reclamation/{id}/flag", name="reclamation_flag")
     * @param Reclamation $reclamation
     * @return RedirectResponse
     */
    public function flag (Reclamation $reclamation): RedirectResponse
    {   $reclamation->setFlag(1);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $idd = $reclamation->getIdRec();
        return $this->redirectToRoute("reclamation_show_back",[
            'id' => $idd
        ]);
    }
    /**
     * @Route("back/reclamation/{id}/unflag", name="reclamation_unflag")
     * @param Reclamation $reclamation
     * @return RedirectResponse
     */
    public function unflag (Reclamation $reclamation): RedirectResponse
    {   $reclamation->setFlag(0);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $idd = $reclamation->getIdRec();
        return $this->redirectToRoute("reclamation_show_back",[
        'id' => $idd
        ]);
    }
    /**
     * @Route("back/reclamation/pdf/{id}", name="reclamation_pdf", methods={"GET"})
     */
    public function generatePdf(Reclamation $reclamation,PDFService $pdf): Response
    {
        $html = $this->render('back/reclamation/pdf.html.twig',['reclamation'=>$reclamation]);
       return $pdf->showPdfFile($html);
    }

}
