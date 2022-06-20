<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
class Livreur extends User
{

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
