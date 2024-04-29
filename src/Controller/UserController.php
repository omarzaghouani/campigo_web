<?php
// src/Controller/UserController.php

namespace App\Controller;
use App\Form\UtilisateurType;
use App\Entity\Utilisateur;
use App\Form\UtilisateurFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Form\Extension\Core\Type\FileType; // Ajoutez cette ligne pour importer FileType
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{
    
    
    
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    #[Route('/users', name: 'user_index')]
    public function index(): Response
    {
        $utilisateur=$this->getDoctrine()->getRepository(Utilisateur::class)->findAll();
        return $this->render('user/index.html.twig',['u'=>$utilisateur]);
    }

    #[Route('/signin', name: 'signin')] 
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $utilisateur = new Utilisateur();
    
        $form = $this->createForm(UtilisateurFormType::class, $utilisateur);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photo_d')->getData();
            if ($photoFile) {
                $newFilename = uniqid().'.'.$photoFile->guessExtension();
    
                // Move the file to the desired directory
                try {
                    $photoFile->move(
                        $this->getParameter('uploaded_directory'), // Directory where photos should be saved
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle file upload error here...
                }
    
                $utilisateur->setPhotoD($newFilename);
            }
    
            $entityManager->persist($utilisateur);
            $entityManager->flush();
    
            return $this->redirectToRoute('user_index');
        }
    
        return $this->render('user/new.html.twig', [
            'u' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/users/{id}', name: 'user_show')]
    public function show($id): Response
    {
        $utilisateur = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);

        if (!$utilisateur) {
            throw $this->createNotFoundException('Aucun utilisateur trouvé pour cet id ' . $id);
        }

        return $this->render('user/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/modifier/{id}', name: 'modifier')]
    public function edit(Request $request, Utilisateur $utilisateur ,EntityManagerInterface $entityManager ): Response
    {
        
        $form = $this->createForm(UtilisateurFormType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoFile = $form->get('photo_d')->getData();
            if ($photoFile) {
                $newFilename = uniqid().'.'.$photoFile->guessExtension();
    
                // Move the file to the desired directory
                try {
                    $photoFile->move(
                        $this->getParameter('uploaded_directory'), // Directory where photos should be saved
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Handle file upload error here...
                }
    
                $utilisateur->setPhotoD($newFilename);
            }
    
            $entityManager->flush();
            return $this->redirectToRoute('user_show', ['id' => $utilisateur->getId()]);
        }

        return $this->render('user/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/supprimer/{id}', name: 'delete')]
    public function delete($id, UtilisateurRepository $centreRepository, EntityManagerInterface $entityManager): Response
    {
    
        $centre = $centreRepository->find($id);
            $entityManager->remove($centre);
            $entityManager->flush();
    
    
        return $this->redirectToRoute('user_index');
    }
    
}