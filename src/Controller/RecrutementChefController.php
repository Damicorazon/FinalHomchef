<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface as Encoder;
use App\Entity\Membre;

class RecrutementChefController extends AbstractController
{
    /**
     * @Route("/recrutement", name="recrutement_chef")
     */
    public function index(Request $request, EntityManagerInterface $em): Response
    {

        if($request->request->has("pseudo")) {
            $pseudo = $request->request->get("pseudo");
        }
        if($request->request->has("prenom")) {
            $prenom = $request->request->get("prenom");
        }
        if($request->request->has("ville")) {
            $ville = $request->request->get("ville");
        }
        if($request->request->has("code_postal")) {
            $cp = $request->request->get("code_postal");
        }

        if($request->request->has("telephone")) {
            $telephone = $request->request->get("telephone");
        }
        if($request->request->has("email")) {
            $mail = $request->request->get("email");
        }
        if($request->request->has("mdp")) {
            $mdp = $request->request->get("mdp");
        }

        if ((!empty($pseudo) && !empty($prenom)) && (!empty($ville) && !empty($mdp))) {
            $nouveauMembre = new Membre;
            $nouveauMembre->setPseudo($pseudo);
            $nouveauMembre->setPrenom($prenom);
            $nouveauMembre->setVille($ville);
            $nouveauMembre->setCP($cp);
            $nouveauMembre->setTelephone($telephone);
            $nouveauMembre->setMail($mail);
            $nouveauMembre->setPassword($mdp);
            $nouveauMembre->setRoles(["ROLE_CHEF"]);

            $em->persist($nouveauMembre);
            $em->flush();
            $this->addFlash("success", "Le nouveau livre a bien été enregistré");
            return $this->redirectToRoute('accueil');
        }
        
        return $this->render('recrutement_chef/index.html.twig');
    }
}
