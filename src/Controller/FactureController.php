<?php

namespace App\Controller;

use App\api\MailerApi;
use App\api\TwilioApi;
use App\Entity\Facture;
use App\Form\FactureType;
use App\Repository\FactureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;


class FactureController extends AbstractController
{
    /**
     * @Route("/factureback", name="facture_index", methods={"GET"})
     */
    public function index(FactureRepository $factureRepository): Response
    {
        return $this->render('facture/index.html.twig', [
            'factures' => $factureRepository->findAll(),
        ]);
    }
    /**
     * @Route("/facturefront/{id}", name="facture_inddex", methods={"GET"})
     */
    public function facc(Facture $facture   ): Response
    {
        return $this->render('facture/Facturefront.html.twig', [
            'facture' => $facture
            
        ]);
    }

    /**
     * @Route("/facture/new", name="facture_new", methods={"GET", "POST"})
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function new(Request $request, EntityManagerInterface $entityManager,MailerInterface $mailer): Response
    {
        $facture = new Facture();
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($facture);
            $entityManager->flush();

            $email = new MailerApi();
            $twilio = new TwilioApi('ACda1976ab5035c6b8b7fe668e22bc944b','776fe32074f4486a49e956cf518adac8','+19124614993');
            $twilio->sendSMS('+21627076474','facture Créer ');
            $email->sendEmail( $mailer,'testapimail63@gmail.com','feriel.mahfoudhi@esprit.tn','testing email','facture Créer ');

            $this->addFlash(
                'info' ,' facture Créer !');


            return $this->redirectToRoute('facture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facture/new.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);


    }

    /**
     * @Route("/factureback/dali/{id}", name="facture_show", methods={"GET"})
     */
    public function show(Facture $facture): Response
    {
        return $this->render('facture/show.html.twig', [
            'facture' => $facture,
        ]);
    }

    /**
     * @Route("/factureback/dali/{id}/edit", name="facture_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('facture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('facture/edit.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/factureback/dali/{id}", name="facture_delete", methods={"POST"})
     */
    public function delete(Request $request, Facture $facture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$facture->getId(), $request->request->get('_token'))) {
            $entityManager->remove($facture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('facture_index', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("/imprimer_f", name="imprimer_f")
     */


        public function imprimefacture(FactureRepository $repository): Response
        {
            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');
            $dompdf = new Dompdf($pdfOptions);
            $facture = $repository->findAll();
            $html = $this->renderView('facture/pdf.html.twig', [
                'facture' => $facture,
            ]);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream("Liste  des factures.pdf", [
                "Attachment" => true
            ]);
            return $this->redirectToRoute('imprimer_com');
        }
    /**
     * @param FactureRepository $repository
     * @param Request $request
     * @return Response
     * @Route ("/recherchef",name="recherchef")
     */
    function Recherchef (FactureRepository $repository,Request $request){


        $data=$request->get('search');
        $facture=$repository->findBy(['numFact'=>$data]);
        return $this->render("facture/index.html.twig",['factures'=>$facture]);

    }

    /**
     * @param FactureRepository $repository
     * @return Response
     * @Route ("/tri",name="tri")
     */
    function OrderByPriceDQL(FactureRepository $repository)
    {
        $facture = $repository->OrderByPriceDQL();
        return $this->render("facture/index.html.twig", ['factures' => $facture]);
    }



}
