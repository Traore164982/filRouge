<?php

namespace App\Controller;

use DateTime;
use App\Entity\Menu;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use ApiPlatform\Core\Filter\Validator\ValidatorInterface;
use App\Repository\BurgerRepository;
use App\Repository\ProduitRepository;
use App\Repository\TailleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
{
    private $manager;
    public function __construct(EntityManagerInterface $manager,TailleRepository $tailleR,
    BurgerRepository $burgerR,ProduitRepository $prodR){
        $this->manager = $manager;
        $this->tailleR = $tailleR;
        $this->burgerR = $burgerR;
        $this->prodR = $prodR;
    }
    public function __invoke(Request $request)
    {
        $content = json_decode($request->getContent());
        if(!isset($content->remise)){
           return $this->json("La remise est requise",Response::HTTP_BAD_REQUEST); 
        }
        if(!isset($content->menuBurgers)){
            return $this->json("Les frites est requises",Response::HTTP_BAD_REQUEST); 
        }
         if(!isset($content->tailles) && !isset($content->frites)){
            return $this->json("Un des Compl\ément est requis",Response::HTTP_BAD_REQUEST); 
        }
        if(!isset($content->nomMenu)){
            return $this->json("L nom est requis",Response::HTTP_BAD_REQUEST); 
         }
         if(!isset($content->prixMenu)){
            return $this->json("Le prix est requise",Response::HTTP_BAD_REQUEST); 
         }
        else{
            $menu = new Menu();
            $menu->setNom($content->nomMenu);
            $menu->setPrix($content->prixMenu);
            $burger = [];
            
            foreach($content->tailles as $taille){
                $t=$this->tailleR->findOneBy(["id"=>$taille->id]);
                $menu->addTaille($t);
            }
            foreach($content->menuBurgers as $b){  
                $burger[] = $b->Burger;
            }
        foreach ($burger as $bu) {
             $t=$this->prodR->find($bu);
             dump($t);
            }

        $t=[];

            /* foreach($content->menuBurgers as $burg){
                $explode = explode("/",$burg->Burger);
                $explode=intVal(end($explode));
                var_dump($explode);
                $burger[] += $explode;
            }
 */
            /* $burg = $this->tailleR->findAll();
            var_dump($burg); */
            /* foreach ($burger as $b) {
                $bur=$this->burgerR->findAll();
                var_dump($bur);
            } */
            dd($menu->getMenuBurgers());
        }
        dd(isset($content->remises));
    }
}
