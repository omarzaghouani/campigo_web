<?php

namespace App\Controller;


use App\Entity\Vehicule;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/statistics')]
class StatisticsController extends AbstractController
{
    #[Route('/num-v', name: 'num_v_statistics')]
    public function numVStatistics(): Response
    {
        $vehicleRepository = $this->getDoctrine()->getRepository(Vehicule::class);
        $vehicles = $vehicleRepository->findAll();

        $numVs = [];
        foreach ($vehicles as $vehicle) {
            $numVs[] = $vehicle->getNumV();
        }

        // Pass the statistics data to the template
        return $this->render('statistics/num_v_statistics.html.twig', [
            'numVs' => $numVs,
        ]);
    }
}
