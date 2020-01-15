<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    private $panierService;

    public function __construct(PanierService $panierService)
    {
        $this->panierService = $panierService;
    }

    /**
     * @Route("/panier", name="panier_index")
     */
    public function index()
    {
        return $this->render('panier/index.html.twig', [
            'items' => $this->panierService->getContenu($this->getDoctrine()),
            'prixTotal' => $this->panierService->getTotal($this->getDoctrine()),
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

    /**
     * @Route("/panier/valider", name="panier_valider")
     */
    public function panierValider()
    {
        //ManagerRegistry $managerRegistry, EntityManagerInterface $entityManager
        $this->panierService->panierToCommande($this->getUser(), $this->getDoctrine(), $this->getDoctrine()->getManager());
        return $this->redirectToRoute('panier_index');
    }
}
