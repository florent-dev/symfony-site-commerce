<?php

namespace App\Controller;

use App\Service\BoutiqueService;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    private $panierService;

    public function __construct(BoutiqueService $boutiqueService)
    {
        $this->panierService = new PanierService(new Session(), $boutiqueService);
    }

    /**
     * @Route("/panier", name="panier_index")
     */
    public function index(PanierService $panierService)
    {
        return $this->render('panier/index.html.twig', [
            'items' => $panierService->getContenu(),
            'prixTotal' => $panierService->getTotal(),
        ]);
    }

    /**
     * @Route("/panier/ajouter/{idProduit}/{quantite}", name="panier_ajouter")
     */
    public function panierAjouter($idProduit, $quantite)
    {
        $this->panierService->ajouterProduit($idProduit, $quantite);
        return $this->redirectToRoute('panier_index');
    }

    /**
     * @Route("/panier/enlever/{idProduit}/{quantite}", name="panier_enlever")
     */
    public function panierEnlever($idProduit, $quantite)
    {
        $this->panierService->enleverProduit($idProduit, $quantite);
        return $this->redirectToRoute('panier_index');
    }

    /**
     * @Route("/panier/supprimer/{idProduit}", name="panier_supprimer")
     */
    public function panierSupprimer($idProduit)
    {
        $this->panierService->supprimerProduit($idProduit);
        return $this->redirectToRoute('panier_index');
    }

    /**
     * @Route("/panier/vider", name="panier_vider")
     */
    public function panierVider()
    {
        $this->panierService->vider();
        return $this->redirectToRoute('panier_index');
    }
}
