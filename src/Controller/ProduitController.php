<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Categorie;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\CategorieRepository;
use App\Repository\ProduitRepository;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;

class ProduitController extends AbstractController
{
    /**
     * @Route("/produit", name="produit")
     */
    public function index(ProduitRepository $produitRepository,Request $request): Response
    {
        $data = new SearchData();
        $form = $this->createForm(\App\Form\SearchType::class,$data);
        $form->handleRequest($request);
        $produit=$produitRepository->findSearch($data);
        return $this->render('produit/listeProduits.html.twig', [
            'produits' => $produit,
            'form'=> $form->createView()
        ]);
    }
    /**
     * @Route("produit/add", name="produit_add")
     * @param Request $request
     * @return Response
     */
    public function add(Request $request, UserRepository $userRepository, MailerInterface $mailer): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($produit->getImage()== "")
                $produit->setImage("no_image.jpg");
            else{
                $file=new File($produit->getImage());
                $fileName=md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'),$fileName);
                $produit->setImage($fileName);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            foreach ($userRepository->findAll() as $user) {
                $email = (new Email())
                    ->from('campi.pidev@gmail.com')
                    ->to($user->getEmail())
                    ->subject('Nouveau Produit')
                    ->html('<p>Bonjour, On est ravi de vous informer qu un nouveau produit <span style="color: red">' . $produit->getNom() . '</span> a été ajouté!</p>');

                $mailer->send($email);
            }



            return $this->redirectToRoute('front_prod');

        }
        return $this->render('produit/add.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("produit/{id}/show", name="produit_show")
     * @param Produit $produit
     * @return Response
     */
    public function show(Produit $produit): Response
    {
        return $this->render("produit/show.html.twig", [
            "produit" => $produit
        ]);
    }

    /**
     * @Route("produit/{id}/edit", name="produit_edit")
     * @param Produit $produit
     * @param Request $request
     * @return Response
     */
    public function edit(Produit $produit, Request $request): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($produit->getImage()== "")
                $produit->setImage("no_image.jpg");
            else{
                $file=new File($produit->getImage());
                $fileName=md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'),$fileName);
                $produit->setImage($fileName);
            }
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('front_prod');
        }
        return $this->render("produit/edit.html.twig", [
            "form" => $form->createView()

        ]);

    }

    /**
     * @Route("produit/{id}/delete", name="produit_delete")
     * @param Produit $produit
     * @return RedirectResponse
     */
    public function delete(Produit $produit): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();

        return $this->redirectToRoute("produit");
    }
    /**
     * @Route("/produit/recherche", name="recherche_prod")
     */
    public function Recherche(ProduitRepository $produitRepository,Request $request)
    {
        $data=$request->get("key");
        $produit=$produitRepository->findAll();
        $chosen=array();
        foreach($produit as $p){
            if(str_contains(strtoupper($p->getNom()), strtoupper($data))){
               array_push($chosen,$p);
            }
        }
        return $this->render('produit/listeProduits.html.twig',
            ['produits' => $chosen]);
    }
    /**
     * @Route("/produit/stats", name="stats")
     */
    public function stat()
    {
        $repository = $this->getDoctrine()->getRepository(Categorie::class);
        $produit = $repository->findAll();

        $em = $this->getDoctrine()->getManager();

        $cat1=0;
        $cat2=0;
        $cat3=0;
        $cat4=0;


        foreach ($produit as $produit)
        {
            if ( $produit->getnomCategorie()=="Tente")  :

                $cat1+=1;
            else:

                $cat2+=1 ;


            endif;

        }
        //$data=array_map(function (Categorie $item){
    //return [$item->getNomCategorie(),5];
//},$repository->findAll());
//dump([array_merge([['categories', 'nombre']],$data)]);die;

        $data=array_map(function (Categorie $item){
            return [$item->getNomCategorie(),$item->getProduits()->count()];
        },$repository->findAll());


        array_unshift($data,['Task', 'Hours per Day']);



        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable($data);
        $pieChart->getOptions()->setTitle('Listes des produits par Catégorie ');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('produit/stats.html.twig', array('piechart' => $pieChart));
    }


}
