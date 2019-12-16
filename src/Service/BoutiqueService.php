<?php
namespace App\Service;
use Symfony\Component\HttpFoundation\RequestStack;

// Un service pour manipuler le contenu de la Boutique
//  qui est composée de catégories et de produits stockés "en dur"
class BoutiqueService {

    // renvoie toutes les catégories
    public function findAllCategories() {
        return $this->categories;
    }

    // renvoie la categorie dont id == $idCategorie
    public function findCategorieById(int $idCategorie) {
        $res = array_filter($this->categories,
                function ($c) use($idCategorie) {
            return $c["id"] == $idCategorie;
        });
        return (sizeof($res) === 1) ? $res[array_key_first($res)] : null;
    }

    // renvoie le produits dont id == $idProduit
    public function findProduitById(int $idProduit) {
        $res = array_filter($this->produits,
                function ($p) use($idProduit) {
            return $p["id"] == $idProduit;
        });
        return (sizeof($res) === 1) ? $res[array_key_first($res)] : null;
    }

    // renvoie tous les produits dont idCategorie == $idCategorie
    public function findProduitsByCategorie(int $idCategorie) {
        return array_filter($this->produits,
                function ($p) use($idCategorie) {
            return $p["idCategorie"] == $idCategorie;
        });
    }

    // renvoie tous les produits dont libelle ou texte contient $search
    public function findProduitsByLibelleOrTexte(string $search) {
        return array_filter($this->produits,
                function ($p) use ($search) {
                  return ($search=="" || mb_strpos(mb_strtolower($p["libelle"]." ".$p["texte"]), mb_strtolower($search)) !== false);
        });
    }

    // constructeur du service : injection des dépendances et tris
    public function __construct(RequestStack $requestStack) {
        // Injection du service RequestStack
        //  afin de pouvoir récupérer la "locale" dans la requête en cours
        $this->requestStack = $requestStack;
        // On trie le tableau des catégories selon la locale
        usort($this->categories, function ($c1, $c2) {
            return $this->compareSelonLocale($c1["libelle"], $c2["libelle"]);
        });
        // On trie le tableau des produits de chaque catégorie selon la locale
        usort($this->produits, function ($c1, $c2) {
            return $this->compareSelonLocale($c1["libelle"], $c2["libelle"]);
        });
    }

    ////////////////////////////////////////////////////////////////////////////

    private function compareSelonLocale(string $s1, $s2) {
        $collator=new \Collator($this->requestStack->getCurrentRequest()->getLocale());
        return collator_compare($collator, $s1, $s2);
    }

    private $requestStack; // Le service RequestStack qui sera injecté
    // Le catalogue de la boutique, codé en dur dans un tableau associatif
    private $categories = [
        [
            "id" => 1,
            "libelle" => "Légumes",
            "visuel" => "category-1.jpg",
            "texte" => "Plus tu en manges, moins tu en es un",
        ],
        [
            "id" => 2,
            "libelle" => "Fruits",
            "visuel" => "category-2.jpg",
            "texte" => "De la passion ou de ton imagination"
        ],
        [
            "id" => 3,
            "libelle" => "Boissons",
            "visuel" => "category-3.jpg",
            "texte" => "Des mixtures aux saveurs extraordinaires",
        ],
    ];
    private $produits = [
        [
            "id" => 1,
            "idCategorie" => 2,
            "libelle" => "Pommes",
            "texte" => "Elle est bonne pour la tienne",
            "visuel" => "produit-pommes.jpg",
            "prix" => 3.42
        ],
        [
            "id" => 2,
            "idCategorie" => 2,
            "libelle" => "Fraises",
            "texte" => "Ici tu n'en es pas une",
            "visuel" => "produit-fraises.jpg",
            "prix" => 2.11
        ],
        [
            "id" => 3,
            "idCategorie" => 1,
            "libelle" => "Carottes",
            "texte" => "Elle va te la donner",
            "visuel" => "produit-carottes.jpg",
            "prix" => 2.84
        ],
        [
            "id" => 4,
            "idCategorie" => 1,
            "libelle" => "Choux-fleurs",
            "texte" => "C'est bon pour ta vue",
            "visuel" => "produit-choux-fleurs.jpg",
            "prix" => 2.90
        ],
        [
            "id" => 5,
            "idCategorie" => 1,
            "libelle" => "Choux violets",
            "texte" => "Fruit ou Légume ? Légume",
            "visuel" => "produit-choux-violets.jpg",
            "prix" => 1.70
        ],
        [
            "id" => 6,
            "idCategorie" => 1,
            "libelle" => "Echalottes",
            "texte" => "Mange des fractales",
            "visuel" => "produit-echalottes.jpg",
            "prix" => 1.81
        ],
        [
            "id" => 7,
            "idCategorie" => 1,
            "libelle" => "Haricots verts",
            "texte" => "C'est bon, sauf pour ta santé",
            "visuel" => "produit-haricots-verts.jpg",
            "prix" => 4.50
        ],
        [
            "id" => 8,
            "idCategorie" => 1,
            "libelle" => "Oignons",
            "texte" => "Y'a pas pire que za",
            "visuel" => "produit-oignons.jpg",
            "prix" => 8.25
        ],
        [
            "id" => 9,
            "idCategorie" => 1,
            "libelle" => "Piments",
            "texte" => "Seulement si tu es un pertubateur",
            "visuel" => "produit-piments.jpg",
            "prix" => 3.75
        ],
        [
            "id" => 10,
            "idCategorie" => 1,
            "libelle" => "Poivrons",
            "texte" => "Si tu aimes les couleurs",
            "visuel" => "produit-poivrons.jpg",
            "prix" => 2.16
        ],
        [
            "id" => 11,
            "idCategorie" => 1,
            "libelle" => "Tomates",
            "texte" => "Rondes et fraiches",
            "visuel" => "produit-tomates.jpg",
            "prix" => 1.80
        ],
        [
            "id" => 12,
            "idCategorie" => 3,
            "libelle" => "Jus multi-fruits",
            "texte" => "Toutes les saveurs en un seul jus",
            "visuel" => "produit-jus-de-fruits.jpg",
            "prix" => 4.50
        ],
    ];
}
