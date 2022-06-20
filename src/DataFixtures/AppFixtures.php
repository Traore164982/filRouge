<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Faker\Factory;
use App\Entity\Gestionnaire;
use App\Entity\Livreur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class AppFixtures extends Fixture
{   public function __construct(UserPasswordHasherInterface $encoder){
    $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create("fr_FR");
        for ($i=0; $i < 10; $i++) { 
            $gest = new Gestionnaire();
            $gest->setNom($faker->lastName());
            $gest->setPrenom($faker->firstName());
            $gest->setTelephone($faker->phoneNumber);
            $gest->setEmail($faker->email);
            $hash = $this->encoder->hashPassword($gest,"Passer");
            $gest->setPassword($hash);
            $manager->persist($gest);
            $cli = new Client();
            $hash = $this->encoder->hashPassword($cli,"Passer");
            $cli->setNom($faker->lastName())
            ->setPrenom($faker->firstName())
            ->setTelephone($faker->phoneNumber)
            ->setEmail($faker->email)
            ->setAdresse("Zone".$i)
            ->setPassword($hash);
            $manager->persist($cli);
            $liv = new Livreur();
            $hash = $this->encoder->hashPassword($cli,"Passer");
            $liv->setNom($faker->lastName())
            ->setPrenom($faker->firstName())
            ->setTelephone($faker->phoneNumber)
            ->setEmail($faker->email)
            ->setMatricule("Mat".$i)
            ->setPassword($hash);
            $manager->persist($liv);            
        }
        $manager->flush();
    }
}
