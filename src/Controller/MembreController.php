<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MembreRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Membre;
use App\Form\MembreType;
use App\Form\ModifMembreType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface as Encoder;


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

        /**
     * @Route("/membre/ajouter", name="membre_ajouter")
     */
    public function nouveau(Request $request, EntityManagerInterface $em, Encoder $encoder){
        $membre = new Membre;
        $formMembre = $this->createForm(MembreType::class, $membre);
        $formMembre->handleRequest($request);
        if( $formMembre->isSubmitted() && $formMembre->isValid() ){
            if( $fichier = $formMembre->get("photo")->getData() ){
                $destination = $this->getParameter("dossier_images");
                $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                $nouveauNom = str_replace(" ", "_", $nomFichier);
                $nouveauNom .= "_" . uniqid() . "." . $fichier->guessExtension();
                $fichier->move($destination, $nouveauNom);
                $membre->setPhoto($nouveauNom);
            }
            $membre->setPassword($encoder->encodePassword($membre, $membre->getPassword() ) );
            $entityManager = $this->getDoctrine()->getManager();
            $em->persist($membre);
            $em->flush();
            $this->addFlash("success", "Le nouveau membre a bien été ajouté");
            return $this->redirectToRoute("membre");
        }
        return $this->render("membre/ajouter.html.twig", ["formMembre" => $formMembre->createView()]);
    }

    /**
     * @Route("/membre/modifier/{id}", name="membre_modifier", methods={"GET","POST"})
     */
    public function edit(Request $request, Encoder $encoder, Membre $membre): Response
    {
        $formModifMembre = $this->createForm(ModifMembreType::class, $membre);
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
            if( trim($mdp) ) {
                $mdp = $encoder->encodePassword($membre, $mdp);
                $membre->setPassword($mdp);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('membre');
        }

        return $this->render('membre/modifier.html.twig', [
            'membre' => $membre,
            'formModifMembre' => $formModifMembre->createView(),
        ]);
    }

    /**
     * @Route("/membre/supprimer/{id}", name="membre_supprimer")
     * 
     */
    public function supprimer(EntityManagerInterface $em, Request $request, MembreRepository $membreR, $id) {

        $membreASupprimer = $membreR->find($id);
        if($request->isMethod("POST") ){
            $em->remove($membreASupprimer);
            $em->flush();
            $this->addFlash("success", "Le membre a bien été supprimé");
            return $this->redirectToRoute('membre');
        }
        return $this->render("membre/supprimer.html.twig", ["membre" => $membreASupprimer]);
    }
}
