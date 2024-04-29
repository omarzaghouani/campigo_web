<?php

use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\Response;

require_once 'vendor/autoload.php'; // Adjust the path as per your project structure

// Function to generate personalized PDF
function generatePdf($transportData)
{
    // Extract transport details
    $numT = $transportData['numT'];
    $transpoteur = $transportData['transpoteur'];
    $vehicule = $transportData['vehicule'];
    $dd = $transportData['dd'];
    $da = $transportData['da'];
    $cout = $transportData['cout'];

    // HTML content for the PDF
    $htmlContent = "
        <html>
        <head>
            <title>Transport Details - $numT</title>
        </head>
        <body>
            <h1>Transport Details</h1>
            <p><strong>Num_t:</strong> $numT</p>
            <p><strong>Transpoteur:</strong> $transpoteur</p>
            <p><strong>Vehicule:</strong> $vehicule</p>
            <p><strong>Dd:</strong> $dd</p>
            <p><strong>Da:</strong> $da</p>
            <p><strong>Cout:</strong> $cout</p>
        </body>
        </html>
    ";

    // Create Dompdf instance
    $dompdf = new Dompdf();
    $dompdf->loadHtml($htmlContent);

    // Set paper size and rendering
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Output the generated PDF
    return new Response(
        $dompdf->output(),
        Response::HTTP_OK,
        ['Content-Type' => 'application/pdf']
    );
}

// Example usage:
$transportData = [
    'numT' => '123',
    'transpoteur' => 'Transporter Name',
    'vehicule' => 'Vehicle Details',
    'dd' => '2024-04-22',
    'da' => '2024-04-23',
    'cout' => '$100',
];
$response = generatePdf($transportData);
$response->send();
