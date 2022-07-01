<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    attributes:[
        "pagination_enabled"=>true,
        "pagination_items_per_page"=>5
    ],
    normalizationContext:[
        "groups"=>[
            "commande:read",
        ]
    ],
    denormalizationContext:[
            "groups"=>[
                "commande:write",
            ]
    ],
    collectionOperations:[
        "GET","POST"
    ],
    itemOperations:[
        "PUT","PATCH","GET"
    ]
)]
#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(
        [
            "commande:read",
            "commande:write",
        ]
    )]
    #[ORM\Column(type: 'string', length: 255)]
    private $etat="En Attente";

    #[Groups(
        [
            "commande:read",
            "commande:write",
        ]
    )]
    #[ORM\Column(type: 'datetime')]
    private $date;

    #[Groups(
        [
            "commande:read",
            "commande:write",
        ]
    )]
    #[ORM\ManyToMany(targetEntity: Produit::class, inversedBy: 'commandes')]
    private $produits;
    #[Groups(
        [
            "commande:read",
            "commande:write",
        ]
    )]
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    private $gestionnaire;
    #[Groups(
        [
            "commande:read",
            "commande:write",
        ]
    )]
    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    private $client;
    #[Groups(
        [
            "commande:read",
            "commande:write",
        ]
    )]
    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
        }

        return $this;
    }

    public function removeProduit(produit $produit): self
    {
        $this->produits->removeElement($produit);

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }
}
