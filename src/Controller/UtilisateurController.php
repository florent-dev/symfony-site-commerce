<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use phpDocumentor\Reflection\Types\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/utilisateur")
 */
class UtilisateurController extends AbstractController
{
    /**
     * @Route("/index", name="utilisateur_index")
     * @param UtilisateurRepository $utilisateurRepository
     * @return Response
     */
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $commandes = $this->getDoctrine()->getRepository(Commande::class)->findBy(['id_utilisateur' => $this->getUser()->getId()]);

        foreach ($commandes as $commande) {
            $ligneCommandes = $this->getDoctrine()->getRepository(LigneCommande::class)->findBy(['id_commande' => $commande->getId()]);
            $commande->setLigneCommandes($ligneCommandes);
        }


        return $this->render('utilisateur/index.html.twig', [
            'utilisateur' => $this->getUser(),
            'commandes' => $commandes,
        ]);
    }

    /*
     * Création automatique d'un utilisateur
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encryptage du mdp et définition du rôle CLIENT
            $utilisateur->setPassword($passwordEncoder->encodePassword($utilisateur, $utilisateur->getPassword()));
            $utilisateur->setRoles(['ROLE_CLIENT']);

            // Sauvegarde
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            $this->get('session')->set('user', $utilisateur);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ]);
    }
}
