<?php

namespace App\Service;

use App\Entity\Utilisateur;
use App\Repository\ArticleRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

// Service pour manipuler le panier et le stocker en session
class PanierService {
    const PANIER_SESSION = 'panier'; // Le nom de la variable de session du panier

    private $session;  // Le service Session
    private $panier = [];   // Tableau associatif idProduit => quantite
    private $articleRepository = null;


    // donc $this->panier[$i] = quantite du produit dont l'id = $i
    // constructeur du service
    public function __construct(SessionInterface $session) {
        // Récupération des services session et des articles en boutique
        $this->session = $session;

        // Récupération du panier en session s'il existe, init. à vide sinon
        $this->panier = $session->get('panier');
        if ($this->panier === null) {
            $this->panier = [];
        }
    }

    public function panierToCommande(Utilisateur $utilisateur) {
        // créé pour cet usager, une commande (et ses lignes de commande) à partir du contenu du panier (s’il n’est pas vide)
        // Le contenu du panier devra être supprimé à l’issue de ce traitement.
        // Cette méthode renverra en résultat l’entité Commande qui aura été créée.
    }

    // getContenu renvoie le contenu du panier
    // tableau d'éléments [ "produit" => un produit, "quantite" => quantite ]
    public function getContenu(ManagerRegistry $managerRegistry) {
        $contenu = [];

        foreach ($this->panier as $idProduit => $quantite) {
            $contenu[] = ['produit' => $this->getArticleRepository($managerRegistry)->find($idProduit), 'quantite' => $quantite];
        }

        return $contenu;
    }

    // getTotal renvoie le montant total du panier
    public function getTotal(ManagerRegistry $managerRegistry) {
        $total = 0;

        foreach ($this->panier as $idProduit => $quantite) {
            $total = $this->getArticleRepository($managerRegistry)->find($idProduit)->getPrix() * $quantite;
        }

        return $total;
    }

    // getNbProduits renvoie le nombre de produits dans le panier
    public function getNbProduits() {
        return count($this->panier);
    }

    // ajouterProduit ajoute au panier le produit $idProduit en quantite $quantite
    public function ajouterProduit(int $idProduit, int $quantite = 1) {

        if ( isset($this->panier[$idProduit]) ) {
            $this->panier[$idProduit] += $quantite;
        } else {
            $this->panier[$idProduit] = $quantite;
        }

        $this->session->set('panier', $this->panier);
    }

    // enleverProduit enlève du panier le produit $idProduit en quantite $quantite
    public function enleverProduit(int $idProduit, int $quantite = 1) {

        if ( isset($this->panier[$idProduit]) ) {
            if ($this->panier[$idProduit] <= 1) {
                unset($this->panier[$idProduit]);
            } else {
                $this->panier[$idProduit] -= $quantite;
            }
        }

        $this->session->set('panier', $this->panier);
    }

    // supprimerProduit supprime complètement le produit $idProduit du panier
    public function supprimerProduit(int $idProduit)
    {
        foreach ($this->panier as $id => $quantite) {
            if ($id == $idProduit) {
                unset($this->panier[$id]);
                break;
            }
        }

        $this->session->set('panier', $this->panier);
    }

    // vider complètement le panier
    public function vider()
    {
        $this->panier = [];
        $this->session->set('panier', $this->panier);
    }

    /**
     * Get the repo
     * @param ManagerRegistry $managerRegistry
     * @return ArticleRepository
     */
    private function getArticleRepository(ManagerRegistry $managerRegistry)
    {
        if (null === $this->articleRepository) {
            $this->articleRepository = new ArticleRepository($managerRegistry);
        }

        return $this->articleRepository;
    }
}