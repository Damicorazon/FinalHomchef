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
     * @Route("/membre/ajouter", name="membre_ajouter", methods={"GET","POST"})
     */
    public function new(Request $request, Encoder $encoder): Response
    {
        $membres = new Membre();
        $formMembre = $this->createForm(MembreType::class, $membres);
        $formMembre->handleRequest($request);

        if ($formMembre->isSubmitted() && $formMembre->isValid()) {
            //la ligne qui suit correspond aux 3 lignes dans la derniere route "nouveau" 
            $membres->setPassword($encoder->encodePassword($membres, $membres->getPassword() ) );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($membres);
            $entityManager->flush();

            return $this->redirectToRoute('membre');
        }

        return $this->render('membre/ajouter.html.twig', [
            'membre' => $membres,
            'formMembre' => $formMembre->createView(),
        ]);
    }

    /**
     * @Route("/menu/modifier/{id}", name="membre_modifier")
     *
     */
    public function modifier(EntityManagerInterface $em, Request $request, MembreRepository $membreR,Encoder $encoder, $id) {
        $membre = $membreR->find($id);
        $formMembre = $this->createForm(MembreType::class, $membre);
        $formMembre->handleRequest($request);
        if( $formMembre->isSubmitted() && $formMembre->isValid() ){
            $mdp = $formMembre->get("password")->getData();
            if( trim($mdp) ) {
            $mdp = $encoder->encodePassword($membre, $mdp);
            $membre->setPassword($mdp);
            }
            $this->getDoctrine()->getManager()->flush();
            if( $fichier = $formMembre->get("photo")->getData() ){
                $destination = $this->getParameter("dossier_images");
                $nomFichier = pathinfo($fichier->getClientOriginalName(), PATHINFO_FILENAME);
                $nouveauNom = str_replace(" ", "_", $nomFichier);
                $nouveauNom .= "_" . uniqid() . "." . $fichier->guessExtension();
                $fichier->move($destination, $nouveauNom);
                $membre->setPhoto($nouveauNom);
            }
            $em->persist($membre);
            $em->flush();
            $this->addFlash("success", "Le membre a bien été modifié");
            return $this->redirectToRoute("membre");
        }
        return $this->render("membre/ajouter.html.twig", ["formMembre" => $formMembre->createView()]);
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
