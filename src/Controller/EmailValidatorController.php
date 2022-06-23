<?php

namespace App\Controller;

use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Json;

class EmailValidatorController extends AbstractController
{
    private $manager;
    public function __construct(EntityManagerInterface $manager){
        $this->manager = $manager;
    }
    public function __invoke(Request $request,UserRepository $userR)
    {
        $token=$request->get('token');
        $user=$userR->findOneBy(["token"=>$token]);

        if(!$user){
            return new JsonResponse(["error"=>"Invalid token"],Response::HTTP_BAD_REQUEST); 
        }
        if($user && $user->getExpire() < date("Y-m-d")){
            return new JsonResponse(["message"=>"Votre Clé a expiré"],Response::HTTP_BAD_REQUEST); 
        }
        if($user->isIsEnable()){
            return new JsonResponse(["message"=>"Le compte est deja activé"],Response::HTTP_BAD_REQUEST); 
        }
        $user->setIsEnable(true);
        $this->manager->flush();
        return new JsonResponse(["success"=>"Bravo, Votre compte est Activé"],Response::HTTP_OK); 
    }
}
