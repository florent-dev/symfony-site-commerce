<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administration")
 */
class AdministrationController extends AbstractController
{
    /**
     * @Route("/", name="admin_index")
     */
    public function index()
    {
        $utilisateurs = $this->getDoctrine()->getRepository(Utilisateur::class)->findAll();

        return $this->render('administration/index.html.twig', [
            'utilisateurs' => $utilisateurs,
        ]);
    }

    /**
     * @Route("/articles", name="admin_articles")
     */
    public function articles()
    {
        $this->redirectToRoute('admin_index');
    }

    /**
     * @Route("/categories", name="admin_categories")
     */
    public function categories() {
        $this->redirectToRoute('admin_index');
    }

    public function navbarAdmin() {

        if ($this->getUser() && in_array('ROLE_ADMIN', $this->getUser()->getRoles())) {
            return $this->render('administration/navbar.html.twig');
        }

        return null;

    }
}
