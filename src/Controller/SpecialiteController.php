<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MenuRepository;

class SpecialiteController extends AbstractController
{
    /**
     * @Route("/specialites", name="specialites")
     */
    public function index(menuRepository $menuRepository): Response
    {
        $liste_menus = $menuRepository->findAll();
        return $this->render('specialite/index.html.twig', [
            'menus' => $liste_menus,
        ]);
    }
}
