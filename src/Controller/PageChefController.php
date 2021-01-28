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
     * @Route("/page_chef/{id}", name="page_chef", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function index(Membre $membre): Response
    {
        $menus = $membre->getMenus();
        //dd($menus);
        $specialites = [];
        foreach ($menus as $menu) {
            $specialites[] = $menu->getSpecialite();
        }
        $specialites = array_unique($specialites);
        //dd($specialites);
        return $this->render('page_chef/index.html.twig', [
            'membre' => $membre,
            'specialites' => $specialites
        ]);
    }
}
