<?php

namespace App\Controller;

use App\Entity\Produits;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProduitsController extends AbstractController
{
    #[Route('/produits', name: 'app_produits')]
   
    public function afficheproduits( EntityManagerInterface $entity): Response
    {
    $produits = $entity->getRepository(Produits::class)->findAll();
    
        return $this->render('produits/index.html.twig', [
            'controller_name' => 'MainController',
            'produit'=>$produits,
        ]);
    }
    #[Route('/prod/{id}', name: 'app_prod')]
    public function prod($id, EntityManagerInterface $entity): Response
    {
    $prods = $entity->getRepository(Produits::class)->findOneBy(['id'=> $id]);
    
        return $this->render('produits/index2.html.twig', [
            'id'=>$id,
            'prod' => $prods
        ]);
    }
    #[Route('/prod3d/{id}', name: 'app_prod3d')]
    public function prod3d($id, EntityManagerInterface $entity): Response
    {
    $prod3d = $entity->getRepository(Produits::class)->findOneBy(['id'=> $id]);
    
        return $this->render('produits/index3.html.twig', [
            'id'=>$id,
            'prod3d' => $prod3d
        ]);
    }

    

}

