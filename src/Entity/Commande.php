<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    const STATUT_LIBELLES = [
        0 => 'Invalide',
        1 => 'En cours',
        2 => 'Terminé',
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_utilisateur;

    /**
     * @ORM\Column(type="date")
     */
    private $date_commande;

    /**
     * @ORM\Column(type="integer")
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LigneCommande", mappedBy="id_commande")
     */
    private $ligneCommandes;

    public function __construct()
    {
        $this->ligneCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->id_utilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $id_utilisateur): self
    {
        $this->id_utilisateur = $id_utilisateur;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->date_commande;
    }

    public function setDateCommande(\DateTimeInterface $date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function getStatutLibelle(): string
    {
        if ($this->statut) {
            return self::STATUT_LIBELLES[$this->statut];
        } else {
            return self::STATUT_LIBELLES[0];
        }
    }

    public function setStatut(int $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getLigneCommandes()
    {
        return $this->ligneCommandes;
    }

    public function setLigneCommandes($ligneCommandes): self
    {
        $this->ligneCommandes = $ligneCommandes;

        return $this;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->setIdCommande($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes->removeElement($ligneCommande);
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getIdCommande() === $this) {
                $ligneCommande->setIdCommande(null);
            }
        }

        return $this;
    }
}
