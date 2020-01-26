<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueController extends AbstractController
{
    /**
     * @Route("/boutique", name="boutique")
     * @return Response
     */
    public function boutique()
    {
        $categories = ( new CategorieRepository($this->getDoctrine()) )->findAll();

        return $this->render('boutique/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/rayon/{idCategory}", name="rayon")
     * @param $idCategory
     * @return Response
     */
    public function rayon($idCategory)
    {
        $products = ( new ArticleRepository($this->getDoctrine()) )->findBy(['id_categorie' => $idCategory]);

        return $this->render('boutique/rayon.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * Recherche par libelle ou texte
     * @Route("/search", name="search")
     * @return Response
     */
    public function search(Request $request)
    {
        $products = null;
        $search = $request->get('productName');

        // TODO : Requête custom Doctrine
        if (null !== $search) {
            $products = ( new ArticleRepository($this->getDoctrine()) )->findBy(['libelle' => $search]);
        }
        return $this->render('boutique/rayon.html.twig', [
            'products' => $products,
        ]);
    }

    public function sideBarTopVentes()
    {
        $topArticles = $this->getDoctrine()->getRepository(Article::class)->getTop3Articles();

        return $this->render('boutique/sidebar_top_ventes.html.twig', [
            'topArticles' => $topArticles,
        ]);
    }
}
