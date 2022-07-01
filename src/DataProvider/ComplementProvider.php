<?php
namespace App\DataProvider;

use App\Entity\Complement;
use App\Repository\FritesRepository;
use App\Repository\BoissonRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

class ComplementProvider implements ContextAwareCollectionDataProviderInterface,RestrictedDataProviderInterface{
    
    public function __construct(BoissonRepository $BoissonR, FritesRepository $fritesR){
        $this->BoissonR = $BoissonR;
        $this->fritesR = $fritesR;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []){
        $Boisson = $this->BoissonR->findAll();
        $frites = $this->fritesR->findAll();
        return $context=[$Boisson,$frites];
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []):bool{
        return $resourceClass == Complement::class;
    }
}