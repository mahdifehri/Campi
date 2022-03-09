<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
                {   
                    if ($user->getPhotoUser()=="")  
                    $user->setPhotoUser("noimage.jpg");
                    else
                    {
                        $file=new File ($user->getPhotoUser());
                        $fileName= md5(uniqid()).'.'.$file->guessExtension();
                        $file->move($this->getParameter('upload_directory'),    $fileName);
                        $user->setPhotoUser($fileName);
                    }
        
                }
            $entityManager->persist($user);
            $entityManager->flush();

           
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/login", name="user_login", methods={"GET","POST"})
     */
    public function login (Request $request): Response
    {
        //$session= $request->getSession();
        //$session->clear();
        $user = new User();
        $form = $this->createFormBuilder($user)
            ->add('email',TextType::class)
            ->add('motpasse',PasswordType::class)
            ->getForm(); 
        $form->handleRequest($request);

        if ($form->isSubmitted())   {
            $motpasse= $user->getMotpasse();
            $email= $user->getEmail();
            $repository= $this->getDoctrine()->getRepository(User::class);
            $user1 = $repository->findOneBy(array('email'=>$email,'motpasse'=>$motpasse));
            if (!$user1)
            {
            $this->get('session')->getFlashBag()->add('info',
            'Login incorrecte vérifier votre email ou mot de passe ...');
            }
            else
            {
               // if(!$session->has('name'))
                //{
                  //  $session->set('name',$user1->getPrenom());
                    //$name=$session->get('name');
                   // if ($user1->getRole()=="Admin");
                    //{
                      //  return $this->render('user/show.html.twig');
                 //   }      
                //}        
            $this->get('session')->getFlashBag()->add('info','Login correct');
            return $this->render('user/show.html.twig');
        }
           
        }
        return $this->render('user/login.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]) ;
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $name= $user->getPhotoUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($user->getPhotoUser()=="")
                $user->setPhotoUser($name);
            else
            {
                $file = new File($user->getPhotoUser());
                $fileName=md5(uniqid()).'.'.$file->guessExtension();
                $file->move($this->getParameter('upload_directory'),    $fileName);
                $user->setPhotoUser($fileName);
                if($name!="no_image.jpg")
                    if (file_exists("photo/".$name))
                        unlink("photo/".$name);
            }
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', 'Votre compte à bien été enregistré.');
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

  
}
