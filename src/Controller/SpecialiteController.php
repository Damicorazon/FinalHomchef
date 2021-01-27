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
    public function index(MenuRepository $menu): Response
    {
        $liste_menu = $menu->findAll();
        return $this->render('specialite/index.html.twig', [
            'menus' => $liste_menu,
        ]);
    }

}
