<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu  extends Produit
{
    #[ORM\Column(type: 'integer')]
    private $remise;

    #[ORM\ManyToOne(targetEntity: burger::class, inversedBy: 'menus')]
    private $produit_id;

    #[ORM\ManyToOne(targetEntity: complement::class, inversedBy: 'menus')]
    private $complement_id;

    public function getRemise(): ?int
    {
        return $this->remise;
    }

    public function setRemise(int $remise): self
    {
        $this->remise = $remise;

        return $this;
    }

    public function getProduitId(): ?burger
    {
        return $this->produit_id;
    }

    public function setProduitId(?burger $produit_id): self
    {
        $this->produit_id = $produit_id;

        return $this;
    }

    public function getComplementId(): ?complement
    {
        return $this->complement_id;
    }

    public function setComplementId(?complement $complement_id): self
    {
        $this->complement_id = $complement_id;

        return $this;
    }
}
