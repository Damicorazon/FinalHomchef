<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageChefController extends AbstractController
{
    /**
     * @Route("/chef", name="page_chef")
     */
    public function index(): Response
    {
        return $this->render('page_chef/index.html.twig', [
            'controller_name' => 'PageChefController',
        ]);
    }
}
