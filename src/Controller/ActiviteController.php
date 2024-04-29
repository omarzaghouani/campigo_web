<?php

namespace App\Controller;
use App\Entity\Activite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ActiviteType;
use App\Repository\ActiviteRepository;




class ActiviteController extends AbstractController
{
    #[Route('/activite', name: 'app_activite')]
    public function index(): Response
    {
        return $this->render('activite/index.html.twig', [
            'controller_name' => 'ActiviteController',
        ]);
    }

    
    #[Route('/afficher_act', name: 'app_afficher_act')]
    public function affiche(): Response
    {
        $activite=$this->getDoctrine()->getRepository(Activite::class)->findAll();
        return $this->render('activite/affiche_activite.html.twig',['a'=>$activite]);
    }
    

    #[Route('/ajouter_act', name: 'app_ajouter_act')]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $activite = new Activite();

    $form = $this->createForm(ActiviteType::class, $activite);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
       
        $entityManager->persist($activite);
        $entityManager->flush();

        return $this->redirectToRoute('app_afficher_act');
    }

    return $this->render('activite/ajouter_activite.html.twig', [
        'a' => $activite,
        'form' => $form->createView(),
    ]);
}



#[Route('/act/modifier/{Nom_activite}', name: 'app_modifier_act')]
public function modifier(Request $request, string $Nom_activite, EntityManagerInterface $entityManager): Response
{
    $activite = $entityManager->getRepository(Activite::class)->findOneBy(['Nom_activite' => $Nom_activite]);

    if (!$activite) {
        throw $this->createNotFoundException('activite non trouvé');
    }

    $form = $this->createForm(ActiviteType::class, $activite);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
    
        $entityManager->flush();

        return $this->redirectToRoute('app_afficher_act');
    }

    return $this->render('activite/modifier_activite.html.twig', [
        'a' => $activite,
        'form' => $form->createView(),
        
    ]);
}





    /*#[Route('/ajoute', name: 'app_ajoute')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entretien = new Entretien();

        $form = $this->createForm(EntretienType::class, $entretien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($entretien);
            $entityManager->flush();

            return $this->redirectToRoute('app_affiche', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('entretien/ajoute.html.twig', ['entretien' => $entretien,'form' => $form,]);
    }
*/
   
#[Route('/admin/activite/Supprimer/{id_activite}', name: 'app_act_supprimer')]
public function delete($id_activite, ActiviteRepository $activiteRepository, EntityManagerInterface $entityManager): Response
{

    $activite = $activiteRepository->find($id_activite);
        $entityManager->remove($activite);
        $entityManager->flush();


    return $this->redirectToRoute('app_afficher_act');
}




}

