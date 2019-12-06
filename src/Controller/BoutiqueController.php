<?php

namespace App\Controller;

use App\Service\BoutiqueService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BoutiqueController extends AbstractController
{
    /**
     * @Route("/boutique", name="boutique")
     * @param BoutiqueService $boutique
     * @return Response
     */
    public function boutique(BoutiqueService $boutique)
    {
        $categories = $boutique->findAllCategories();

        return $this->render('boutique/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/rayon/{idCategory}", name="rayon")
     * @param BoutiqueService $boutique
     * @param $idCategory
     * @return Response
     */
    public function rayon(BoutiqueService $boutique, $idCategory)
    {
        $products = $boutique->findProduitsByCategorie($idCategory);

        return $this->render('boutique/rayon.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/search", name="search")
     * @param BoutiqueService $boutique
     * @return Response
     */
    public function search(BoutiqueService $boutique, Request $request)
    {
        $products = null;

        if (null !== $request->get('productName')) {
            $products = $boutique->findProduitsByLibelleOrTexte($request->get('productName'));
        }
        return $this->render('boutique/rayon.html.twig', [
            'products' => $products,
        ]);
    }
}
