<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\MenuController;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Cascade;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ApiResource(
    attributes:[
        "pagination_enabled"=>true,
        "pagination_items_per_page"=>5
    ],
    normalizationContext:[
        "groups"=>[
            "menus:read",
        ]
    ],
    denormalizationContext:[
        "groups"=>[
            "menu:write",
            "menu:write:self"
        ]
    ],
    collectionOperations:[
        "GET","POST"=>[
            "deserialize"=>false,
            "controller"=>MenuController::class
        ]
    ],
    itemOperations:[
        "GET","PUT","PATCH"
    ]
)]
#[ORM\Entity(repositoryClass: MenuRepository::class)]
class Menu  extends Produit
{
    #[Groups([
        "menu:read",
        "menu:write"
    ])]
    #[ORM\Column(type: 'integer')]
    protected $remise;
    
    
    #[Groups([
        "menu:read",
        "menu:write",
    ])]
    #[ORM\ManyToMany(targetEntity: Frites::class, inversedBy: 'menus',cascade:["persist"])]
    protected $frites;
    #[Groups([
        "menu:read",
        "menu:write",
    ])]
    #[ORM\ManyToMany(targetEntity: Taille::class, mappedBy: 'menus')]
    private $tailles;

    #[Groups([
        "menu:write"
    ])]
    #[ORM\OneToMany(mappedBy: 'Menu', targetEntity: MenuBurger::class,cascade:["persist"])]
    private $menuBurgers;

    #[Groups([
        "menu:write"
    ])]
    private $nomMenu;

    #[Groups([
        "menu:write"
    ])]
    private $prixMenu;


    public function __construct()
    {
        parent::__construct();
        $this->boissons = new ArrayCollection();
        $this->frites = new ArrayCollection();
        $this->tailles = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
    }

    public function getRemise(): ?int
    {
        return $this->remise;
    }

    public function setRemise(int $remise): self
    {
        $this->remise = $remise;

        return $this;
    }


    /**
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self
    {
        $this->boissons->removeElement($boisson);

        return $this;
    }

    /**
     * @return Collection<int, Frites>
     */
    public function getFrites(): Collection
    {
        return $this->frites;
    }

    public function addFrite(Frites $frite): self
    {
        if (!$this->frites->contains($frite)) {
            $this->frites[] = $frite;
        }

        return $this;
    }

    public function removeFrite(Frites $frite): self
    {
        $this->frites->removeElement($frite);

        return $this;
    }

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
            $taille->addMenu($this);
        }

        return $this;
    }

    public function removeTaille(Taille $taille): self
    {
        if ($this->tailles->removeElement($taille)) {
            $taille->removeMenu($this);
        }

        return $this;
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
            $menuBurger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenu() === $this) {
                $menuBurger->setMenu(null);
            }
        }

        return $this;
    }

    public function getNomMenu(): ?string
    {
        return $this->nomMenu;
    }

    public function setNomMenu(string $nomMenu): self
    {
        $this->nomMenu = $nomMenu;

        return $this;
    }


    /**
     * Get the value of prixMenu
     */ 
    public function getPrixMenu()
    {
        return $this->prixMenu;
    }

    /**
     * Set the value of prixMenu
     *
     * @return  self
     */ 
    public function setPrixMenu($prixMenu)
    {
        $this->prixMenu = $prixMenu;

        return $this;
    }
}
