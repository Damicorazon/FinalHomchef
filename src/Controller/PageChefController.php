<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MenuRepository;
use App\Repository\MembreRepository;
use App\Entity\Membre;
use App\Entity\Menu;

class PageChefController extends AbstractController
{
    /**
     * @Route("/chef/{id}", name="page_chef", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Membre $m): Response
    {
        return $this->render('page_chef/index.html.twig', [
            'membre' => $m,
        ]);
    }
}
