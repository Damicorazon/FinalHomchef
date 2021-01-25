<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MenuRepository;

class MenuController extends AbstractController
{
    /**
     * @Route("/menu", name="menu")
     */
    public function index(MenuRepository $menu): Response
    {
        $liste_menus = $menu->findAll();
        return $this->render('menu/index.html.twig', [
            'menus' => $liste_menus,
        ]);
    }

    /** 
     * @Route("/menu/fiche/{id}", name="menu_fiche")
     */
    public function fiche(MenuRepository $menu, $id)
    {
    $menu = $menu->find($id);
        return $this->render('menu/fiche.html.twig', [
            'menu' => $menu,
        ]);
    }

}
