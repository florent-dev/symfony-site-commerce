<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LigneCommandeRepository")
 */
class LigneCommande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="ligneCommandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commande", inversedBy="ligneCommandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_commande;

    public function __construct()
    {
        $this->id_article = new ArrayCollection();
        $this->id_commande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdArticle(): ?Article
    {
        return $this->id_article;
    }

    public function setIdArticle(?Article $id_article): self
    {
        $this->id_article = $id_article;

        return $this;
    }

    public function getIdCommande(): ?Commande
    {
        return $this->id_commande;
    }

    public function setIdCommande(?Commande $id_commande): self
    {
        $this->id_commande = $id_commande;

        return $this;
    }
}
