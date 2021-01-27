<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MembreRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


    /**
     * @IsGranted("ROLE_ADMIN")
     * 
     */
class MembreController extends AbstractController
{
    /**
     * @Route("/membre", name="membre")
     */
    public function index(MembreRepository $membreR): Response
    {

        $liste_membres = $membreR->findAll();
        return $this->render('membre/index.html.twig', [
            'membres' => $liste_membres,

        ]);
    }

    /**
     * @Route("/membre/identite", name="membre_identite")
     */
    public function identite(MembreRepository $membreR): Response
    {
        $liste_membres = $membreR->findAll();
        return $this->render('membre/identite.html.twig', [
            'membres' => $liste_membres,
        ]);
    }

    /**
     * @Route("/membre/adresse", name="membre_adresse")
     */
    public function adresse(MembreRepository $membreR): Response
    {
        $liste_membres = $membreR->findAll();
        return $this->render('membre/adresse.html.twig', [
            'membres' => $liste_membres,
        ]);
    }
}
