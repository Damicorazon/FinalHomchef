<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecrutementChefController extends AbstractController
{
    /**
     * @Route("/recrutement", name="recrutement_chef")
     */
    public function index(): Response
    {
        return $this->render('recrutement_chef/index.html.twig', [
            'controller_name' => 'RecrutementChefController',
        ]);
    }
}
