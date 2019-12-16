<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Service\BoutiqueService;

// Service pour manipuler le panier et le stocker en session
class PanierService {
    const PANIER_SESSION = 'panier'; // Le nom de la variable de session du panier

    private $session;  // Le service Session
    private $boutique; // Le service Boutique
    private $panier = [];   // Tableau associatif idProduit => quantite

    // donc $this->panier[$i] = quantite du produit dont l'id = $i
    // constructeur du service
    public function __construct(SessionInterface $session, BoutiqueService $boutique) {
        // Récupération des services session et BoutiqueService
        $this->boutique = $boutique;
        $this->session = $session;
        // Récupération du panier en session s'il existe, init. à vide sinon
        $this->panier = $session->get('panier');
    }

    // getContenu renvoie le contenu du panier
    // tableau d'éléments [ "produit" => un produit, "quantite" => quantite ]
    public function getContenu() {
        return $this->panier;
    }

    // getTotal renvoie le montant total du panier
    public function getTotal() {
        $total = 0;

        foreach ($this->panier as $product) {
            $total = $this->boutique->findProduitById($product['produit'])['prix'] * $product['quantite'];
        }

        return $total;
    }

    // getNbProduits renvoie le nombre de produits dans le panier
    public function getNbProduits() {
        $somme = 0;

        foreach ($this->panier as $product) {
            $somme += $product['quantite'];
        }

        return $somme;
    }

    // ajouterProduit ajoute au panier le produit $idProduit en quantite $quantite
    public function ajouterProduit(int $idProduit, int $quantite = 1) {

        // Si le produit existe déjà dans le panier
        $existe = false;

        foreach ($this->panier as $key => $value) {
            if ($value[0] == $idProduit) {
                $this->panier[$key][1] += $quantite;
                $existe = true;
                break;
            }
        }

        // Autrement on l'ajoute
        if (!$existe) {
            $this->panier[] = [$idProduit, $quantite];
        }
    }

    // enleverProduit enlève du panier le produit $idProduit en quantite $quantite
    public function enleverProduit(int $idProduit, int $quantite = 1) {

        foreach ($this->panier as $key => $value) {
            if ($value[0] == $idProduit) {
                $this->panier[$key][1] -= $quantite;
                break;
            }
        }

    }

    // supprimerProduit supprime complètement le produit $idProduit du panier
    public function supprimerProduit(int $idProduit)
    {

        foreach ($this->panier as $key => $value) {
            if ($value[0] == $idProduit) {
                unset($this->panier[$key]);
                break;
            }
        }

    }

    // vider vide complètement le panier
    public function vider()
    {
        $this->panier = [];
    }
}