<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MenuRepository;

class AcceuilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(MenuRepository $menu): Response
    {
        $liste_menus = $menu->findAll();
        return $this->render('acceuil/index.html.twig', [
            'menus' => $liste_menus,
        ]);
    }
}
