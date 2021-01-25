<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MenuRepository;
use App\Entity\Menu;
use App\Form\MenuType;

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

    /**
     * @Route("/menu/ajouter", name="menu_ajouter")
     */
    public function nouveau(Request $request, EntityManagerInterface $em){
        $menu = new Menu;
        $formMenu = $this->createForm(MenuType::class, $menu);
        $formMenu->handleRequest($request);
        if( $formMenu->isSubmitted() && $formMenu->isValid() ){
            if( $fichier = $formMenu->get("photos")->getData() ){
                $destination = $this->getParameter("dossier_images");
                $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                $nouveauNom = str_replace(" ", "_", $nomFichier);
                $nouveauNom .= "_" . uniqid() . "." . $fichier->guessExtension();
                $fichier->move($destination, $nouveauNom);
                $menu->setCouverture($nouveauNom);
            }
            $em->persist($menu);
            $em->flush();
            $this->addFlash("success", "Le nouveau menu a bien été ajouté");
            return $this->redirectToRoute("menu");
        }
        return $this->render("menu/ajouter.html.twig", ["formMenu" => $formMenu->createView()]);
    }
}
