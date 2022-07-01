<?php
namespace App\DataProvider;

use App\Entity\Catalogue;

use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

class CatalogueProvider implements ContextAwareCollectionDataProviderInterface,RestrictedDataProviderInterface{
    
    public function __construct(BurgerRepository $burgerR, MenuRepository $menuR){
        $this->burgerR = $burgerR;
        $this->menuR = $menuR;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []){
        $burger = $this->burgerR->findBy(["isEtat"=>true]);
        $menu = $this->menuR->findBy(["isEtat"=>true]);
        return $context=[$burger,$menu];
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []):bool{
        return $resourceClass == Catalogue::class;
    }
}