<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
#[ApiResource(
    attributes:[
        "pagination_enabled"=>true,
        "pagination_items_per_page"=>4
    ],
    normalizationContext:[
        "groups"=>[
            "zone:read"
        ]
    ],
    denormalizationContext:[
        "groups"=>[
            "zone:write"
        ]
    ],
    collectionOperations:[
        "GET","POST"
    ],
    itemOperations:[
        "PUT","GET","PATCH"
    ]
)]
#[ORM\Entity(repositoryClass: ZoneRepository::class)]
class Zone
{
    #[Groups(
        [
        "livraison:write",
        "commande:write",
        ]
    )]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;
    #[Groups([
        "zone:read",
        "zone:write"
    ])]
    #[ORM\Column(type: 'string', length: 255)]
    protected $libelle;
    #[Groups([
        "zone:read",
        "zone:write"
    ])]
    #[ORM\Column(type: 'integer')]
    protected $prix;
    #[Groups([
        "zone:read",
        "zone:write"
    ])]
    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Quartier::class)]
    protected $quartiers;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Livraison::class)]
    private $livraisons;

    public function __construct()
    {
        $this->quartiers = new ArrayCollection();
        $this->livraisons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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

    public function getQuartier(): ?quartier
    {
        return $this->quartier;
    }

    public function setQuartier(?quartier $quartier): self
    {
        $this->quartier = $quartier;

        return $this;
    }

    /**
     * @return Collection<int, Quartier>
     */
    public function getQuartiers(): Collection
    {
        return $this->quartiers;
    }

    public function addQuartier(Quartier $quartier): self
    {
        if (!$this->quartiers->contains($quartier)) {
            $this->quartiers[] = $quartier;
            $quartier->setZone($this);
        }

        return $this;
    }

    public function removeQuartier(Quartier $quartier): self
    {
        if ($this->quartiers->removeElement($quartier)) {
            // set the owning side to null (unless already changed)
            if ($quartier->getZone() === $this) {
                $quartier->setZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setZone($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getZone() === $this) {
                $livraison->setZone(null);
            }
        }

        return $this;
    }

}
