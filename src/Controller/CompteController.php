<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Membre;
use App\Form\ModifMembreClientType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface as Encoder;

class CompteController extends AbstractController
{
    /**
     * @Route("/compte", name="compte")
     */
    public function index(): Response
    {
        $info_membre = $this->getUser();
        return $this->render('compte/index.html.twig', [
            'membre' => $info_membre,
        ]);
    }
    /**
     * @Route("/compte/description/{id}", name="compte_description")
     */
    public function description(): Response{
        $description = $this->getUser();
        return $this->render('compte/description.html.twig', [
            'membre' => $description,
        ]);
    }
    /**
     * @Route("/compte/{id}/modifier", name="compte_modifier", methods={"GET","POST"})
     */

    public function edit(Request $request, Encoder $encoder, Membre $membre): Response
    {
        $formModifMembre = $this->createForm(ModifMembreClientType::class, $membre);
        $formModifMembre->handleRequest($request);

        if ($formModifMembre->isSubmitted() && $formModifMembre->isValid()) {
            if( $fichier = $formModifMembre->get("photo")->getData() ){
                $destination = $this->getParameter("dossier_images");
                $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                $nouveauNom = str_replace(" ", "_", $nomFichier);
                $nouveauNom .= "_" . uniqid() . "." . $fichier->guessExtension();
                $fichier->move($destination, $nouveauNom);
                $membre->setPhoto($nouveauNom);
            }
            $mdp = $formModifMembre->get("password")->getData();
            if (trim($mdp)) {
                $mdp = $encoder->encodePassword($membre, $mdp);
                $membre->setPassword($mdp);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('compte');
        }
        return $this->render('compte/modifier.html.twig', [
            'membre' => $membre,
            'formModifMembre' => $formModifMembre->createView(),
        ]);
    }
}
