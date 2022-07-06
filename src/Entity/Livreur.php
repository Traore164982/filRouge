<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    attributes:[
        "pagination_enabled" => true,
        "pagination_items_per_page"=>3
    ],
    normalizationContext:[
        "groups" => [
            "livreur:read"
        ]
        ],
    denormalizationContext:[
        "groups"=> [
            "livreur:write"
        ]
        ],
        collectionOperations:[
            "POST","GET"
        ],
        itemOperations:[
            "GET","PUT","PATCH"
        ]
)]
#[ORM\Entity(repositoryClass: LivreurRepository::class)]
class Livreur extends User
{
    public function __construct(){
        parent::__construct();
        $this->roles =["ROLE_LIVREUR"];
        $this->livraisons = new ArrayCollection();
    }

    #[Groups(["livreur:read","livreur:write"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $matricule;

    #[ApiSubresource()]
    #[ORM\OneToMany(mappedBy: 'livreur', targetEntity: Livraison::class)]
    private $livraisons;

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

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
            $livraison->setLivreur($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getLivreur() === $this) {
                $livraison->setLivreur(null);
            }
        }

        return $this;
    }
}
