<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface as Session;
use App\Entity\Commande, App\Entity\Detail;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface as EntityManager;

/**
 * @Route("/panier")
 */
class PanierController extends AbstractController
{
    /**
     * @Route("/", name="panier")
     */
    public function index(Session $session)
    {
        $panier = $session->get("panier");
        return $this->render('panier/index.html.twig', ["panier" => $panier]);
    }

    /**
     * @Route("/ajouter/{id}", name="panier_ajouter", requirements={"id"="\d+"})
     */
    public function ajouter(Request $rq, Session $session, ProduitRepository $pr, $id)
    {
        $panier = $session->get("panier", []); // le 2ième paramètre est renvoyé si "panier" n'existe pas dans la session
        $produit = $pr->find($id);
        $qte = $rq->query->get("qte");
        $qte = empty($qte) ? 1 : $qte;
        $produitExiste = false;
        if ($produit) {
            foreach ($panier as $indice => $ligne) {
                if ($produit->getId() == $ligne["produit"]->getId()) {
                    $qte += $ligne["quantite"];
                    $panier[$indice]["quantite"] = $qte;
                    $produitExiste = true;
                }
            }
            if (!$produitExiste) {
                $panier[] = ["produit" => $produit, "quantite" => $qte];
            }
            $this->addFlash("success", "Le produit <strong>" . $produit->getReference() . "</strong> a été ajouté au panier");
            $session->set("panier", $panier);
        } else {
            $this->addFlash("danger", "Le produit n°$id n'existe pas");
        }
        return $this->redirectToRoute("accueil");
    }

    /**
     * @Route("/vider", name="panier_vider")
     */
    public function vider(Session $session)
    {
        $session->remove("panier");
        return $this->redirectToRoute("panier");
    }

    /**
     * @Route("/supprimer-produit/{id}", name="panier_supprimer_produit", requirements={"id"="\d+"})
     */
    public function supprimer(Session $session, $id)
    {
        $panier = $session->get("panier");
        foreach ($panier as $indice => $ligne) {
            if ($ligne["produit"]->getId() == $id) {
                unset($panier[$indice]);
                break;
            }
        }
        $session->set("panier", $panier);
        return $this->redirectToRoute("panier");
    }

    /**
     * @Route("/modifier-quantite/{id}", name="panier_modifier_produit", requirements={"id"="\d+"})

     */
    public function modifier(Request $rq, Session $session, $id)
    {
        $panier = $session->get("panier");
        $qte = $rq->query->get("qte");
        $qte = empty($qte) ? 1 : $qte;
        foreach ($panier as $indice => $ligne) {
            if ($ligne["produit"]->getId() == $id) {
                $panier[$indice]["quantite"] = $qte;
                break;
            }
        }

        $session->set("panier", $panier);
        return $this->redirectToRoute("panier");
    }

    /**
     * @Route("/valider", name="panier_valider")
     */
    public function valider(Session $session, EntityManager $em, ProduitRepository $pr)
    {
        $panier = $session->get("panier");
        $cmd = new Commande;
        $cmd->setMembre($this->getUser());
        $cmd->setDateEnregistrement(new \DateTime("now"));
        $cmd->setEtat("en attente");
        $montant = 0;
        foreach ($panier as $ligne) {
            $montant += $ligne["produit"]->getPrix() * $ligne["quantite"];

            // ⚠ : il ne faut surtout pas utiliser $ligne["produit"] dans setProduit
            //      L'entity manager essaiera de créer un nouveau produit bien que $ligne["produit"] ait un id non nul
            //      Donc on récupère le produit avec le ProduitRepository
            $produit = $pr->find($ligne["produit"]->getId());

            $detail = new Detail;
            $detail->setCommande($cmd);
            $detail->setProduit($produit);
            $detail->setQuantite($ligne["quantite"]);
            $detail->setPrix($produit->getPrix());

            // EXO : vérifier que la quantité commandée ne dépasse pas le stock
            //       sinon, réduire la quantité commandée (= stock)
            // 📣 Rappel : La méthode Produit::setStock a été modifiée
            $produit->setStock(-$ligne["quantite"]);
            $em->persist($detail);
        }
        $cmd->setMontant($montant);
        $em->persist($cmd);
        $em->flush();
        $session->remove("panier");
        return $this->redirectToRoute("profil");
    }
}
