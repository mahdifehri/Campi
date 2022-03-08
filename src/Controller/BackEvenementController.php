<?php

namespace App\Controller;

use App\Entity\Evenement;

use App\Repository\EvenementRepository;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Mime\Email;

class BackEvenementController extends AbstractController
{
    /**
     * @Route("/back/evenement", name="back_evenement")
     * @param EvenementRepository $evenementRepository
     * @return Response
     */

    public function index(EvenementRepository $evenementRepository): Response
    {

        $repository = $this->getDoctrine()->getRepository(evenement::class);
        $evenements = $repository->findAll();
        $r1=0;
        $r2=0;
        $r3=0;
        foreach ($evenements as $evenement)
        {
            if ( $evenement->getEtat()==1)  :

                $r1+=1;
            elseif ( $evenement->getEtat()==2) :
                $r2+=1;
            else:

                $r3+=1;


            endif;

        }

        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['etat', 'nombre'],
                ['Validé', $r1],
                ['Refusé', $r2],
                ['En cours', $r3],
            ]
        );
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->setBackgroundColor('#191c24');
        $pieChart->getOptions()->getLegend()->getTextStyle()->setColor('#FFFFFF');
        $pieChart->getOptions()->getLegend()->setPosition('bottom');




        return $this->render('back_evenement/index.html.twig',[
            "evenements"=>  $evenementRepository->findAll(),'piechart' => $pieChart
        ]);
    }

    /**
     * @Route("back/evenement/{id}/valide", name="backevenement_valide")
     * @param Evenement $evenement
     * @return RedirectResponse
     */
    public function valide (Evenement $evenement,MailerInterface $mailer): RedirectResponse
    {
        $evenement->setEtat(1);

            $email = (new Email())
                ->from('campi.pidev@gmail.com')
                ->to($evenement->getUsers()->getEmail())
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Campi.Tn-Evénement validé')
                ->text('Sending emails is fun again!')
                ->html('<p>Bonjour, On est ravi de vous informer que votre événement a été validé !</p>');

            $mailer->send($email);

            $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute("back_evenement");
    }
    /**
     * @Route("back/evenement/{id}/refuse", name="backevenement_refuse")
     * @param Evenement $evenement
     * @return RedirectResponse
     */
    public function refuse (Evenement $evenement,MailerInterface $mailer): RedirectResponse
    {   $evenement->setEtat(2);
        $email = (new Email())
            ->from('campi.pidev@gmail.com')
            ->to($evenement->getUsers()->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Campi.Tn-Evénement refusé')
            ->text('Sending emails is fun again!')
            ->html('<p>Bonjour, Nous avons le regret de vous informer que votre événement a été refusé !</p>');

        $mailer->send($email);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        return $this->redirectToRoute("back_evenement");
    }
}
