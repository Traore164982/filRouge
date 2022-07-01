<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;

#[ApiResource(
    collectionOperations:[
        "complements"=>[
            'method'=>'get',
            'path'=>'/complements'
        ]
    ],
    itemOperations:[]
)]
class Complement
{

}
