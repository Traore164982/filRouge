<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource(
    collectionOperations:[
        "catalogue"=>[
            'method'=>'get',
            'path'=>'/catalogue'
        ]
    ],
    itemOperations:[]
)]
class Catalogue
{

}
