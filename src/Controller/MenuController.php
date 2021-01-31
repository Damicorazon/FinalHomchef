<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Menu;
use App\Entity\Membre;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\MenuRepository;
use App\Form\MenuType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


    /**
     * @IsGranted("ROLE_CHEF")
     *
     */
class MenuController extends AbstractController
{
    /**
     * @Route("/menu", name="menu")
     */
    public function index(MenuRepository $menuR): Response
    {

        $membre = $this->getUser();
        $nb_menus = $menuR->findAll($membre->getMenus());
        return $this->render('menu/index.html.twig', [
            'nombre_menu' => $nb_menus
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
            if( $fichier = $formMenu->get("photo")->getData() ){
                $destination = $this->getParameter("dossier_images");
                $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                $nouveauNom = str_replace(" ", "_", $nomFichier);
                $nouveauNom .= "_" . uniqid() . "." . $fichier->guessExtension();
                $fichier->move($destination, $nouveauNom);
                $menu->setPhoto($nouveauNom);
            }
            $membre = $this->getUser();
            $menu->setMembre($membre);
            $em->persist($menu);
            $em->flush();
            $this->addFlash("alert alert-info", "Le nouveau menu a bien été ajouté");
            return $this->redirectToRoute("menu");
        }
        return $this->render("menu/ajouter.html.twig", ["formMenu" => $formMenu->createView()]);
    }

    /**
     * @Route("/menu/modifier/{id}", name="menu_modifier")
     *
     */
    public function maj(EntityManagerInterface $em, Request $request, MenuRepository $menuRepository, $id) {
        $menu = $menuRepository->find($id);
        $formMenu = $this->createForm(MenuType::class, $menu);
        $formMenu->handleRequest($request);
        if( $formMenu->isSubmitted() && $formMenu->isValid() ){
            if( $fichier = $formMenu->get("photo")->getData() ){
                $destination = $this->getParameter("dossier_images");
                $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                $nouveauNom = str_replace(" ", "_", $nomFichier);
                $nouveauNom .= "_" . uniqid() . "." . $fichier->guessExtension();
                /* le fichier uploadé est enregistré dans un dossier temporaire. On va le
                    déplacer vers le dossier images avec le nouveau nom de fichier */
                $fichier->move($destination, $nouveauNom);
                $menu->setPhoto($nouveauNom);
            }
            $em->persist($menu);
            $em->flush();
            $this->addFlash("success", "Le menu a bien été modifié");
            return $this->redirectToRoute("menu");
        }
        return $this->render("menu/ajouter.html.twig", ["formMenu" => $formMenu->createView()]);
    }

    /**
     * @Route("/menu/supprimer/{id}", name="menu_supprimer")
     *
     */
    public function supprimer(EntityManagerInterface $em, Request $request, MenuRepository $menuR, $id) {

        $menuASupprimer = $menuR->find($id);
        if($request->isMethod("POST") ){
            $em->remove($menuASupprimer);
            $em->flush();
            $this->addFlash("success", "Le menu a bien été supprimé");
            return $this->redirectToRoute('menu');
        }
        return $this->render("menu/supprimer.html.twig", ["menu" => $menuASupprimer]);
    }
}
