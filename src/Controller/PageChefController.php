<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MembreRepository;
use App\Entity\Membre;

class PageChefController extends AbstractController
{
    /**
     * @Route("/chef", name="page_chef")
     */
    public function index(MembreRepository $membre): Response
    {
        $page_chef = $membre->findAll();
        return $this->render('page_chef/index.html.twig', [
            'membres' => $page_chef,
        ]);
    }
}
