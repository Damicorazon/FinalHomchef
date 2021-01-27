<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
<<<<<<< HEAD
use App\Entity\Membre;
use App\Repository\MembreRepository;
=======
use App\Repository\MenuRepository;
use App\Repository\MembreRepository;
use App\Entity\Membre;
use App\Entity\Menu;
>>>>>>> develop

class PageChefController extends AbstractController
{
    /**
     * @Route("/chef/{id}", name="page_chef", methods={"GET"}, requirements={"id"="\d+"})
     */
<<<<<<< HEAD
    public function index(MembreRepository $membre): Response
    {
        $page_chef = $membre->findAll();
        return $this->render('page_chef/index.html.twig', [
            'page_chef' => $page_chef,

=======
    public function show(MembreRepository $mr, $id): Response
    {
       // dd($mr);
        return $this->render('page_chef/index.html.twig', [
            'membre' => $mr->find($id)
>>>>>>> develop
        ]);
    }
}
