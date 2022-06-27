<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use ApiPlatform\Core\Annotation\ApiResource;
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
    }
    #[Groups(["livreur:read","livreur:write"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $matricule;

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }
}
