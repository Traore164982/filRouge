<?php

namespace App\Entity;

use Attribute;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

#[ApiResource(
    attributes:[
        "pagination_enabled" =>true,
        "pagination_items_per_page" => 3
    ],
    normalizationContext: [
        "groups"=>
        [
            "client:read"
        ]],
        denormalizationContext: [
            "groups"=>
            [
                "client:write"
            ]
            ],
    collectionOperations:[
        "GET","POST"
    ],
    itemOperations:[
        "GET","PUT","PATCH"
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ["adresse"=>"partial"])]

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client extends User
{
    #[Groups(["client:read","client:write"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $adresse;


    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }
}
