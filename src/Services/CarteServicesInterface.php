<?php
namespace App\Services;
interface CarteServicesInterface  {
    public function addproduits($produitsId); 
    public function removeProduits($produitsId);  
    public function getCart();

}


