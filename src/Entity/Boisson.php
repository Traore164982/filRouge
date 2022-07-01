<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
#[ApiResource(
    attributes:[
        "pagination_enabled"=>true,
        "pagination_items_per_page"=>4
    ],
    normalizationContext:[
        "groups"=>[
            "boisson:read"
        ]
        ],
    denormalizationContext:[
        "groups"=>[
            "boisson:write"
        ]
        ],
        collectionOperations:[
            "GET","POST"
        ],
        itemOperations:[
            "PUT","PATCH","GET"
        ]
)]
#[ORM\Entity(repositoryClass: BoissonRepository::class)]
class Boisson extends Produit
{

    #[Groups(
        [
            "menu:write"
        ]
    )]
    #[ORM\ManyToMany(targetEntity: Taille::class, mappedBy: 'boissons')]
    private $tailles;

    public function __construct()
    {
        parent::__construct();
        $this->menus = new ArrayCollection();
        $this->tailles = new ArrayCollection();
    }

    /**
     * @return Collection<int, Menu>
     */
    /**
     * @return Collection<int, Taille>
     */
    public function getTailles(): Collection
    {
        return $this->tailles;
    }

    public function addTaille(Taille $taille): self
    {
        if (!$this->tailles->contains($taille)) {
            $this->tailles[] = $taille;
            $taille->addBoisson($this);
        }

        return $this;
    }

    public function removeTaille(Taille $taille): self
    {
        if ($this->tailles->removeElement($taille)) {
            $taille->removeBoisson($this);
        }

        return $this;
    }
}
