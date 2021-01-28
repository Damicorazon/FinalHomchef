<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Membre;
use App\Entity\Menu;
use App\Repository\MembreRepository;
use App\Repository\MenuRepository;


class PageReservationController extends AbstractController
{
    /**
     * @Route("/reservation/{id}", name="page_reservation")
     */
    public function index(Membre $membre, MenuRepository $menu, $id): Response
    {
        $menu = $menu->find($id);
        $membre = $menu->getMembre($id);
        // dd($menu);
        return $this->render('page_reservation/index.html.twig', [
            'menu' => $menu,
            'membre' => $membre
        ]);
    }
}
