<?php
namespace App\DataPersister;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Services\MailerServices;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DataPersister implements ContextAwareDataPersisterInterface{
    
    public function __construct(UserPasswordHasherInterface $encoder,EntityManagerInterface $manager, MailerServices $mailer){
        $this->encoder = $encoder;
        $this->mailer = $mailer;
        $this->manager = $manager;
    }

    public function supports($data,$context=[]):bool{
        return $data instanceof User;
    }
    /**
     * @param User $data
     * 
     */
    public function persist($data,$context=[]){
        if($data->getPlainPassword()){
            $hash = $this->encoder->hashPassword($data,$data->getPlainPassword());
            $data->setPassword($hash);
            $data->eraseCredentials();
            $this->manager->persist($data);
            $this->manager->flush();
            $this->mailer->sendEmail($data);
            
        }
    }

    public function remove($data,$context=[]){

    }
}