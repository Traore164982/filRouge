<?php
namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\User;
use App\Entity\Burger;
use App\Entity\Commande;
use App\Services\MailerServices;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DataPersister implements ContextAwareDataPersisterInterface{
    
    public function __construct(UserPasswordHasherInterface $encoder,EntityManagerInterface $manager, MailerServices $mailer,TokenStorageInterface $token){
        $this->encoder = $encoder;
        $this->mailer = $mailer;
        $this->manager = $manager;
        $this->token = $token->getToken();
    }

    public function supports($data,$context=[]):bool{
        return $data instanceof User or $data instanceof Commande or $data instanceof Burger or $data instanceof Menu;
    }
    /**
     * @param User $data
     * 
     */
    public function persist($data,$context=[]){
        if ($data instanceof Menu) {
            $data->setNom($data->getNomMenu());
            dd($data->getNom());
        }
        if($data instanceof Commande){
            if($this->token->getUser()){
                $date = new \DateTime('now');
                $data->setDate($date);
                $data->setClient($this->token->getUser());
                $tra =$data->getLigneCommandes();
                foreach($tra as $tr){
                    $price = $tr->getProduit()->getPrix();
                    $tr->setPrix($price);
                    $this->manager->persist($tr);
                }
            }
        }else{
                   
        if($data->getPlainPassword()){
            $hash = $this->encoder->hashPassword($data,$data->getPlainPassword());
            $data->setPassword($hash);
            $data->eraseCredentials();
            $this->manager->persist($data);
            $this->mailer->sendEmail($data);
            
        }
    }
    $this->manager->flush();
}

    public function remove($data,$context=[]){
        if ($data instanceof Burger) {
            $data->setIsEtat(false);
            $this->manager->persist($data);
            $this->manager->flush();
        }
        if ($data instanceof Commande) {
            $data->setEtat("Annuléé");
            $this->manager->persist($data);
            $this->manager->flush();
        }
    }
}