<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="page_reservation")
     */
    public function index(): Response
    {
        return $this->render('page_reservation/index.html.twig', [
            'controller_name' => 'PageReservationController',
        ]);
    }
}
