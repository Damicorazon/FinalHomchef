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
     * @Route("/{id}/modifier", name="membre_modifier", methods={"GET","POST"})
     */
    public function edit(Request $request, Encoder $encoder, Membre $membre): Response
    {
        $formMembre = $this->createForm(MembreType::class, $membre);
        $formMembre->handleRequest($request);

        if ($formMembre->isSubmitted() && $formMembre->isValid()) {
            $mdp = $formMembre->get("password")->getData();
            if( trim($mdp) ) {
            $mdp = $encoder->encodePassword($membre, $mdp);
            $membre->setPassword($mdp);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('membre');
        }
        return $this->render('membre/ajouter.html.twig', [
            'membre' => $membre,
            'formMembre' => $formMembre->createView(),
        ]);
    }
}
