<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\MembreRepository;

/**
 * @IsGranted("ROLE_CHEF")
 *
 */

class CompteController extends AbstractController
{
    /**
     * @Route("/compte/fiche/{id}", name="compte")
     */
    public function index(MembreRepository $membre, $id): Response
    {
        $info_membre = $membre->find($id);
        $info_membre = $this->getUser();
        return $this->render('compte/index.html.twig', [
            'membre' => $info_membre,
        ]);
    }
    // /**
    //  * @Route("/compte/description/{id}", name="compte")
    //  */
    // public function description(MembreRepository $membre, $id): Response{
    //     $description = $membre->find($id);
    //     $description = $this->getUser();
    //     return $this->render('compte/description.html.twig', [
    //         'description' => $description,
    //     ]);
    // }

}
