<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuBurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    attributes:[
        "pagination_enabled"=>true,
        "pagination_items_per_page"=>5
    ],
    normalizationContext:[
        "groups"=>[
            "menu_burger:read"
        ]
    ],
    denormalizationContext:[
            "groups"=>[
                "menu_burger:write"
            ]
    ],
    collectionOperations:[
        "GET","POST"
    ],
    itemOperations:[
        "PUT","GET","PATCH"
    ]
    
)]
#[ORM\Entity(repositoryClass: MenuBurgerRepository::class)]
class MenuBurger
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;
    #[Groups([
        "menu:read",
        "menu:write",
    ])]
    #[ORM\Column(type: 'integer')]
    private $qte;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuBurgers')]
    private $Menu;
    
    
    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menuBurgers')]
    private $Burger;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->Menu;
    }

    public function setMenu(?Menu $Menu): self
    {
        $this->Menu = $Menu;

        return $this;
    }

    public function getBurger(): ?Burger
    {
        return $this->Burger;
    }

    public function setBurger(?Burger $Burger): self
    {
        $this->Burger = $Burger;

        return $this;
    }
}
