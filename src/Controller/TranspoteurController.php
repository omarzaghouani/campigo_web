<?php

namespace App\Controller;

use App\Entity\Transpoteur;
use App\Form\TranspoteurType;
use App\Repository\TranspoteurRepository;
use App\Services\EmailSender;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/transpoteur')]
class TranspoteurController extends AbstractController
{
    #[Route('/', name: 'app_transpoteur_index', methods: ['GET'])]
    public function index(TranspoteurRepository $transpoteurRepository): Response
    {
        return $this->render('transpoteur/index.html.twig', [
            'transpoteurs' => $transpoteurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_transpoteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $transpoteur = new Transpoteur();
        $form = $this->createForm(TranspoteurType::class, $transpoteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($transpoteur);
            $entityManager->flush();
            $email=new EmailSender();
            $email->sendEmail("omarzaghouani01@gmail.com","le transpoteur ajouter","valide");

            return $this->redirectToRoute('app_transpoteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transpoteur/new.html.twig', [
            'transpoteur' => $transpoteur,
            'form' => $form,
        ]);
    }

    #[Route('/{num_ch}', name: 'app_transpoteur_show', methods: ['GET'])]
    public function show(Transpoteur $num_ch): Response
    {
        return $this->render('transpoteur/show.html.twig', [
            'transpoteur' => $num_ch,
        ]);
    }

    #[Route('/{num_ch}/edit', name: 'app_transpoteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transpoteur $num_ch, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TranspoteurType::class, $num_ch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_transpoteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transpoteur/edit.html.twig', [
            'transpoteur' => $num_ch,
            'form' => $form,
        ]);
    }

    #[Route('/{num_ch}', name: 'app_transpoteur_delete', methods: ['POST'])]
    public function delete(Request $request, Transpoteur $num_ch, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$num_ch->getNumCh(), $request->request->get('_token'))) {
            $entityManager->remove($num_ch);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_transpoteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
