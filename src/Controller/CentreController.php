<?php

namespace App\Controller;

use App\Entity\Centre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\FileType; // Ajoutez cette ligne pour importer FileType
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CentreType;
use App\Repository\CentreRepository;



class CentreController extends AbstractController
{
    #[Route('/k', name: 'app_centre_back')]
    public function back(): Response
    {
        return $this->render('base.html.twig', [
            'controller_name' => 'CentreController',
        ]);
    }



    #[Route('', name: 'app_centre')]
    public function index(): Response
    {
        return $this->render('basefront.html.twig', [
            'controller_name' => 'CentreController',
        ]);
    }


    #[Route('/afficher', name: 'app_afficher')]
    public function affiche(): Response
    {
        $centre=$this->getDoctrine()->getRepository(Centre::class)->findAll();
        return $this->render('centre/affiche_centre.html.twig',['c'=>$centre]);
    }
    

    #[Route('/ajouter', name: 'app_ajouter')]
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $centre = new Centre();

    $form = $this->createForm(CentreType::class, $centre);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $photoFile = $form->get('photo')->getData();
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

            $centre->setPhoto($newFilename);
        }

        $entityManager->persist($centre);
        $entityManager->flush();

        return $this->redirectToRoute('app_afficher');
    }

    return $this->render('centre/ajouter_centre.html.twig', [
        'c' => $centre,
        'form' => $form->createView(),
    ]);
}



#[Route('/centre/modifier/{nom_centre}', name: 'app_modifier')]
public function modifier(Request $request, string $nom_centre, EntityManagerInterface $entityManager): Response
{
    $centre = $entityManager->getRepository(Centre::class)->findOneBy(['nom_centre' => $nom_centre]);

    if (!$centre) {
        throw $this->createNotFoundException('Centre non trouvé');
    }

    $form = $this->createForm(CentreType::class, $centre);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $photoFile = $form->get('photo')->getData();
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

            $centre->setPhoto($newFilename);
        }
        $entityManager->flush();

        return $this->redirectToRoute('app_afficher');
    }

    return $this->render('centre/modifier_centre.html.twig', [
        'c' => $centre,
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
   
#[Route('/admin/Centre/Supprimer/{id_centre}', name: 'app_centre_supprimer')]
public function delete($id_centre, CentreRepository $centreRepository, EntityManagerInterface $entityManager): Response
{

    $centre = $centreRepository->find($id_centre);
        $entityManager->remove($centre);
        $entityManager->flush();


    return $this->redirectToRoute('app_afficher');
}




}
