<?php

namespace App\Controller;

use App\Entity\Transport;
use App\Form\TransportType;
use App\Repository\TransportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;

use Twilio\Rest\Client;

use Symfony\Component\HttpFoundation\JsonResponse;


class TransportController extends AbstractController
{
    #[Route('/transport', name: 'app_transport_index')]
    public function index(Request $request, TransportRepository $transportRepository, PaginatorInterface $paginator): Response
    {
        $allTransportsQuery = $transportRepository->createQueryBuilder('t')
            ->getQuery();

        // Paginate the results
        $transports = $paginator->paginate(
            $allTransportsQuery, // Query to paginate
            $request->query->getInt('page', 1), // Current page number, 1 by default
            5 // Number of items per page
        );

        return $this->render('transport/index.html.twig', [
            'transports' => $transports, // Fix variable name here
        ]);
    }


    #[Route('/transport/front', name: 'app_transport_front')]
    public function front(TransportRepository $transportRepository, Request $request): Response
{
    // Récupérer le paramètre de requête pour le tri (ascendant ou descendant)
    $sortOrder = $request->query->get('sort_order', 'asc'); // Par défaut, tri ascendant

    // Déterminer l'ordre de tri en fonction du choix de l'utilisateur
    $sortDirection = $sortOrder === 'asc' ? 'ASC' : 'DESC';

    // Récupérer la liste des transports triés par coût et selon l'ordre spécifié
    $transportsQueryBuilder = $transportRepository->createQueryBuilder('t')
        ->orderBy('t.cout', $sortDirection); // Tri par coût et ordre spécifié

    // Exécuter la requête pour obtenir la liste des transports
    $transports = $transportsQueryBuilder->getQuery()->getResult();

    return $this->render('transport/front.html.twig', [
        'transports' => $transports,
    ]);
}

    #[Route('/transport/new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $transport = new Transport();
        $form = $this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($transport);
            $entityManager->flush();

            return $this->redirectToRoute('app_transport_index');
        }

        return $this->render('transport/new.html.twig', [
            'transport' => $transport,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/transport/{num_t}', name: 'app_transport_show')]
    public function show(Transport $transport): Response
    {
        return $this->render('transport/show.html.twig', [
            'transport' => $transport,
        ]);
    }

    #[Route('/transport/{num_t}/edit')]
    public function edit(Request $request, Transport $transport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TransportType::class, $transport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->sendTwilioMessage($transport);
            return $this->redirectToRoute('app_transport_index');
        }

        return $this->render('transport/edit.html.twig', [
            'transport' => $transport,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/transport/{num_t}/delete', name: 'app_transport_delete', methods: ['DELETE'])]
    public function delete(Request $request, Transport $transport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transport->getNumT(), $request->request->get('_token'))) {
            $entityManager->remove($transport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_transport_index');
    }

    #[Route('/transport/{num_t}/pdf', name: 'app_transport_pdf', methods: ['GET'])]
public function generatePdf(Transport $transport): Response
{
    // Load the logo image
    $logoPath = $this->getParameter('kernel.project_dir') . '/public/images/logoCampigo.png';

    // Load the PDF template
    $html = $this->renderView('transport/pdf_template.html.twig', [
        'transport' => $transport,
        'logoPath' => $logoPath, // Pass the logo path to the template
    ]);

    // Generate PDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Output the generated PDF
    return new Response(
        $dompdf->output(),
        Response::HTTP_OK,
        ['Content-Type' => 'application/pdf']
    );
}

/**
 * @throws ConfigurationException
 * @throws TwilioException
 */
private function sendTwilioMessage(Transport $transport): void
{
    if (
        !$this->getParameter('twilio_account_sid') ||
        !$this->getParameter('twilio_auth_token') ||
        !$this->getParameter('twilio_phone_number')
    ) {
        throw new ConfigurationException('Twilio parameters are not properly configured.');
    }

    $twilioAccountSid = $this->getParameter('twilio_account_sid');
    $twilioAuthToken = $this->getParameter('twilio_auth_token');
    $twilioPhoneNumber = $this->getParameter('twilio_phone_number');

    $twilioClient = new Client($twilioAccountSid, $twilioAuthToken);

    $messageBody = sprintf(
        'Your transport details:' .
        "\nNum_T: %s\nDD: %s\nDA: %s\nCout: %s",
        $transport->getNumT(),
        $transport->getDd()->format('Y-m-d'),
        $transport->getDa()->format('Y-m-d'),
        $transport->getCout()
    );

    $twilioClient->messages->create(
        '+21626834008', // Replace with the recipient's phone number
        [
            'from' => $twilioPhoneNumber,
            'body' => $messageBody
        ]
    );
}
#[Route('/transport/events', name: 'app_transport_events')]
public function events(TransportRepository $transportRepository): Response
{
    $transports = $transportRepository->findAll();

    $events = [];
    foreach ($transports as $transport) {
        $events[] = [
            
            'start' => $transport->getDd()->format('Y-m-d\TH:i:s'),
            'end' => $transport->getDa()->format('Y-m-d\TH:i:s'),
        ];
    }

    return $this->json($events);
}
#[Route('/stat', name: 'services_plus_achetes')]
public function servicesPlusAchetes(TransportRepository $transportRepository): Response
{
    $mostPurchasedTransports = $transportRepository->countMostPurchasedTransports();

    $stats = [];
    foreach ($mostPurchasedTransports as $transport) {
        $stats[] = [
            'type' => $transport['num_t'], // Assuming 'num_t' represents the type
            'count' => $transport['cout'], // Assuming 'cout' represents the count
        ];
    }

    return $this->render('transport/stat.html.twig', [
        'stats' => $stats,
    ]);
}

}
