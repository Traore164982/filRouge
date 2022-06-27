<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComplementRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ComplementRepository::class)]
#[ApiResource(
    attributes:[
        "pagination_enabled"=>true,
        "pagination_items_per_page"=>4
    ],
    normalizationContext:[
        "groups"=>[
            "complement:read"
        ]
    ],
    denormalizationContext:[
        "groups"=>[
            "complement:write"
        ]
    ],
    collectionOperations:[
        "GET","POST"
    ],
    itemOperations:[
        "PUT","PATCH","GET"
    ]
)]
class Complement extends Produit
{
    #[ORM\OneToMany(mappedBy: 'complement_id', targetEntity: Menu::class)]
    protected $menus;

    #[Groups([
        "type:read",
        "type:write",
    ])]
    #[ORM\ManyToOne(targetEntity: type::class, inversedBy: 'complements')]
    protected $type;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setComplementId($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getComplementId() === $this) {
                $menu->setComplementId(null);
            }
        }

        return $this;
    }

    public function getType(): ?type
    {
        return $this->type;
    }

    public function setType(?type $type): self
    {
        $this->type = $type;

        return $this;
    }
}
