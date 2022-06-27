<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TypeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
#[ApiResource(
    attributes:[
        "pagination_enabled"=>true,
        "pagination_items_per_page"=>5
    ],
    collectionOperations:[
        "GET","POST"
    ],
    itemOperations:[
        "GET","PUT","PATCH"
    ],
    normalizationContext:[
        "groups"=>[
            "type:read"
        ]
    ],
    denormalizationContext:[
        "groups"=>[
            "type:write"
        ]
    ]
)]
#[ORM\Entity(repositoryClass: TypeRepository::class)]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(
        [
            "type:read",
            "type:write",
        ]
    )]
    #[ORM\Column(type: 'string', length: 255)]
    protected $nom;

    #[Groups(
        [
            "type:read",
            "type:write",
        ]
    )]
    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Complement::class)]
    protected $complements;

    #[Groups(
        [
            "type:read",
            "type:write",
        ]
    )]
    #[ORM\ManyToMany(targetEntity: caracteristique::class, inversedBy: 'types')]
    protected $caracteristiques;

    public function __construct()
    {
        $this->complements = new ArrayCollection();
        $this->caracteristiques = new ArrayCollection();
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

    /**
     * @return Collection<int, Complement>
     */
    public function getComplements(): Collection
    {
        return $this->complements;
    }

    public function addComplement(Complement $complement): self
    {
        if (!$this->complements->contains($complement)) {
            $this->complements[] = $complement;
            $complement->setType($this);
        }

        return $this;
    }

    public function removeComplement(Complement $complement): self
    {
        if ($this->complements->removeElement($complement)) {
            // set the owning side to null (unless already changed)
            if ($complement->getType() === $this) {
                $complement->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, caracteristique>
     */
    public function getCaracteristiques(): Collection
    {
        return $this->caracteristiques;
    }

    public function addCaracteristique(caracteristique $caracteristique): self
    {
        if (!$this->caracteristiques->contains($caracteristique)) {
            $this->caracteristiques[] = $caracteristique;
        }

        return $this;
    }

    public function removeCaracteristique(caracteristique $caracteristique): self
    {
        $this->caracteristiques->removeElement($caracteristique);

        return $this;
    }
}
