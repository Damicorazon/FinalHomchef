<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MenuRepository;
use App\Repository\MembreRepository;
use App\Entity\Membre;

class PageChefController extends AbstractController
{
    /**
     * @Route("/chef", name="page_chef")
     */
    public function index(MenuRepository $menu): Response
    {

        $membre = $this->getUser();
        dd($menu->);
        $menu_specialite = $menu->findByjointMembreMenu($membre->getUsername());

        return $this->render('page_chef/index.html.twig', [
            'membres' => $membre,
            'menus' => $menu_specialite
        ]);
    }
}
