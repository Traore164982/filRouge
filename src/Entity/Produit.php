<?php

namespace App\Entity;

use App\Entity\Commande;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type",type:"string")]
#[ORM\DiscriminatorMap(["menu"=>"Menu","burger"=>"Burger","boisson"=>"Boisson","frites"=>"Frites"])]
#[ORM\Entity(repositoryClass: ProduitRepository::class)]

#[ApiResource(
    itemOperations:[
        "GET","PATCH","PUT"
    ]
)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(
        [
            "menu:write",
            "commande:write"
        ]
    )]
    protected $id;

    #[Groups(
        [
            "burger:read",
            "burger:write",
            "frites:read",
            "frites:write",
            "boisson:read:",
            "boisson:write",
            "menu:write:self"
        ]
    )]

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message:"Le nom est Obligatoire")]
    protected $nom;
    #[Groups(
        [
            "burger:read",
            "burger:write",
            "frites:read",
            "frites:write",
            "boisson:read:",
            "boisson:write",
            "menu:write:self"
        ]
    )]
    #[ORM\Column(type: 'integer')]
    #[Assert\NotBlank(message:"Le prix est Obligatoire")]
    protected $prix;
    #[Groups(
        [  
            "burger:read",
            "burger:write",
            "frites:read",
            "frites:write",
            "boisson:read:",
            "boisson:write",
            "menu:write:self"
        ]
    )]       
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $image;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'produits')]
    protected $commandes;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    private $gestionnaire;

    #[ORM\Column(type: 'boolean')]
    private $isEtat=true;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeProduit($this);
        }

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

    public function isIsEtat(): ?bool
    {
        return $this->isEtat;
    }

    public function setIsEtat(bool $isEtat): self
    {
        $this->isEtat = $isEtat;

        return $this;
    }
}
