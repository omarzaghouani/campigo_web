<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FullCalendarBundle\Service\FullCalendar;
use App\Service\CustomFullCalendarService;

class CalendarController extends AbstractController
{
    /**
     * @Route("/calendar", name="calendar")
     */
    public function index(FullCalendar $fullCalendar): Response
    {
        // You can customize FullCalendar options here
        $calendar = $fullCalendar->createCalendar('calendar', [
            // Add FullCalendar options here
        ]);

        // Add events to the calendar (you can fetch events from your database here)
        $calendar->addEvent('Event 1', new \DateTime('2024-04-23T10:00:00'), new \DateTime('2024-04-23T12:00:00'));
        $calendar->addEvent('Event 2', new \DateTime('2024-04-24T14:00:00'), new \DateTime('2024-04-24T16:00:00'));

        // Render the FullCalendar template
        return $this->render('calendar/index.html.twig', [
            'calendar' => $calendar,
        ]);
    }
}