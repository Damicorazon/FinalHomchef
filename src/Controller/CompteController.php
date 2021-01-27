<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\MembreRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Membre;
use App\Form\MembreType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface as Encoder;

/**
 * @IsGranted("ROLE_CHEF")
 *
 */

class CompteController extends AbstractController
{
    /**
     * @Route("/compte", name="compte")
     */
    public function index(MembreRepository $membre): Response
    {
        //$info_membre = $membre->find($id);
        $info_membre = $this->getUser();
        return $this->render('compte/index.html.twig', [
            'membre' => $info_membre,
        ]);
    }
    /**
     * @Route("/compte/description/{id}", name="compte_description")
     */
    public function description(MembreRepository $membre, $id): Response{
        $description = $membre->find($id);
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
        $formMembre = $this->createForm(MembreType::class, $membre);
        $formMembre->handleRequest($request);

        if ($formMembre->isSubmitted() && $formMembre->isValid()) {
            $mdp = $formMembre->get("password")->getData();
            if (trim($mdp)) {
                $mdp = $encoder->encodePassword($membre, $mdp);
                $membre->setPassword($mdp);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('compte');
        }
        return $this->render('compte/modifier.html.twig', [
            'membre' => $membre,
            'formMembre' => $formMembre->createView(),
        ]);
    }
}
