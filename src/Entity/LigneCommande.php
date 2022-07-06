<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LigneCommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    attributes:[
        "pagination_enabled"=>true,
        "pagination_items_per_page"=>5
    ],
    normalizationContext:[
        "groups"=>[
            "ligne:read",
        ]
    ],
    denormalizationContext:[
        "groups"=>[
            "ligne:write"
        ]
    ],
    collectionOperations:[
        "GET","POST"
    ],
    itemOperations:[
        "GET","PUT","PATCH"
    ]
)]
#[ORM\Entity(repositoryClass: LigneCommandeRepository::class)]
class LigneCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[Groups(
        [
            "commande:write",
            "ligne:write"
        ]
    )]
    #[ORM\Column(type: 'integer')]
    private $quantite;
    #[Groups(
        [
            "commande:write",
            "ligne:write"
        ]
    )]
    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'ligneCommandes',cascade:['persist'])]
    private $Produit;

    #[Groups(
        [
            "ligne:write"
        ]
    )]
    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'ligneCommandes',cascade:['persist'])]
    private $Commande;

    #[ORM\Column(type: 'integer')]
    private $prix;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }


    public function getProduit(): ?Produit
    {
        return $this->Produit;
    }

    public function setProduit(?Produit $Produit): self
    {
        $this->Produit = $Produit;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->Commande;
    }

    public function setCommande(?Commande $Commande): self
    {
        $this->Commande = $Commande;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
