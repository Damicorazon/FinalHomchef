<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Membre;

class PageReservationController extends AbstractController
{
    /**
     * @Route("/reservation/{id}", name="page_reservation", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function index(Membre $membre): Response
    {
        //dd($membre);
        return $this->render('page_reservation/index.html.twig', [
            'membre' => $membre,
        ]);
    }
}
