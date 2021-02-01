<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Membre;
use App\Repository\MenuRepository;


class PageReservationController extends AbstractController
{
    /**
     * @Route("/reservation/{id}", name="page_reservation")
     */
    public function index(MenuRepository $menu, $id): Response
    {
        $menu = $menu->find($id);
        // $membre = $menu->getMembre($id);
        // dd($menu);
        return $this->render('page_reservation/index.html.twig', [
            'menu' => $menu,
            // 'membre' => $membre
        ]);
    }
}
