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

    public function navbarAdmin() {
        return $this->render('navbar_admin.html.twig', [
            'is_admin' => $this->getUser() && in_array('ROLE_ADMIN', $this->getUser()->getRoles())
        ]);
    }
}
