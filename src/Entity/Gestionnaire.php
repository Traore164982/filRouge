<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionnaireRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
#[ApiResource(
    attributes:[
        "pagination_enabled" => true,
        "pagination_items_per_page"=>3
    ],
    normalizationContext:[
        "groups" => [
            "gestionnaire:read"
        ]
        ],
    denormalizationContext:[
        "groups"=> [
            "gestionnaire:write"
        ]
        ],
        collectionOperations:[
            "POST","GET"
        ],
        itemOperations:[
            "GET","PUT","PATCH"
        ]
)]
class Gestionnaire extends User
{
    public function __construct(){
        parent::__construct();
        $this->roles =["ROLE_GESTIONNAIRE"];
    }
}
