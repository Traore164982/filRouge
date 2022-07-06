<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\Common\Annotations\Annotation\Attributes;


#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    attributes:[
        "pagination_enabled"=>true,
        "pagination_items_per_page"=>5
    ],
    normalizationContext:[
        "groups"=> "burger:read"
    ],
    denormalizationContext:[
        "groups"=> "burger:write"
    ],
    collectionOperations:[
        "GET"/* =>[
            "security" => "is_granted('IS_ACCESS',object)",
        ] */,
        "POST"/* => [
            "security" => "is_granted('IS_ACCESS',object)",
            "security_message" => "Vous n'avez pas accés à cette route"
        ] */
    ],
    itemOperations:[
        "GET","PUT","PATCH","delete",
    ]
)]
class Burger extends Produit
{
    #[ORM\OneToMany(mappedBy: 'Burger', targetEntity: MenuBurger::class)]
    private $menuBurgers;

    public function __construct()
    {
        parent::__construct();
        $this->menuBurgers = new ArrayCollection();
    }

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setBurger($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getBurger() === $this) {
                $menuBurger->setBurger(null);
            }
        }

        return $this;
    }
}
