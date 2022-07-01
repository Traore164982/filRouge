<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FritesRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    attributes:[
        "pagination_enabled"=>true,
        "pagination_items_per_page"=>4
    ],
    normalizationContext:[
        "groups"=>[
            "frites:read"
        ]
        ],
    denormalizationContext:[
        "groups"=>[
            "frites:write"
        ]
        ],
        collectionOperations:[
            "GET","POST"
        ],
        itemOperations:[
            "PUT","PATCH","GET"
        ]
)]
#[ORM\Entity(repositoryClass: FritesRepository::class)]
class Frites extends Produit
{
    #[Groups(["frites:read", "frites:write","menu:read"])]
    #[ORM\Column(type: 'string', length: 255)]
    protected $pot;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'frites')]
    private $menus;

    public function __construct()
    {
        parent::__construct();
        $this->menus = new ArrayCollection();
    }

    public function getPot(): ?string
    {
        return $this->pot;
    }

    public function setPot(string $pot): self
    {
        $this->pot = $pot;

        return $this;
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
            $menu->addFrite($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeFrite($this);
        }

        return $this;
    }
}
