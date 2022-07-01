<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
#[ApiResource(
    attributes:[
        "pagination_enabled"=>true,
        "pagination_items_per_page"=>5
    ],
    normalizationContext:[
        "groups"=>[
            "taille:read"
        ]
    ],
    denormalizationContext:[
        "groups"=>[
            "taille:write"
        ]
    ],
    collectionOperations:[
        "GET","POST"
    ],
    itemOperations:[
        "PUT","GET","PATCH"
    ]

)]
#[ORM\Entity(repositoryClass: TailleRepository::class)]
class Taille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(
        [
            "menu:write"
        ]
    )]
    private $id;
    
    #[Groups(
        [
            "taille:write","taille:read","menu:read"
        ]
    )]
    #[ORM\Column(type: 'string', length: 255)]
    private $libelle;
    #[Groups(
        [
            "taille:write","taille:read","menu:read"
        ]
    )]
    #[ORM\Column(type: 'integer')]
    private $prix;

    #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'tailles')]
    private $boissons;

    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'tailles')]
    private $menus;

    public function __construct()
    {
        $this->boissons = new ArrayCollection();
        $this->menus = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        $this->menus->removeElement($menu);

        return $this;
    }
}
