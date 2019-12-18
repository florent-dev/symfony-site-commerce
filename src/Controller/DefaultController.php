<?php

namespace App\Controller;

use App\Service\PanierService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('default/contact.html.twig');
    }

    public function navBar(PanierService $panierService)
    {
        return $this->render('navbar.html.twig', [
            'panier_number' => $panierService->getNbProduits(),
        ]);
    }
}
