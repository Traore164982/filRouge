<?php
namespace App\DataPersister;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Commande;
use App\Services\MailerServices;
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
        return $data instanceof User or $data instanceof Commande;
    }
    /**
     * @param User $data
     * 
     */
    public function persist($data,$context=[]){
        if($data instanceof Commande){
            if($this->token->getUser()){
                $data->setGestionnaire($this->token->getUser());
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

    }
}