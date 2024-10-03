<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Services\CarteServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    private $cartService;
    public function __construct( CarteServices $cartService){
        $this->cartService = $cartService;

    }

    #[Route('/cart/add/{id}', name: 'cart_add')]

    public function addproduits(int $id): RedirectResponse {
        $this->cartService->addproduits($id);
        return $this->redirectToRoute('cart_show');

    }
    #[Route('/cart', name: 'cart_show')]
public function showCart(EntityManagerInterface $entitymanager): Response
{
    // Récupérer le contenu du panier
    $cart = $this->cartService->getCart(); 
    $products = [];

    // Récupérer les détails des produits à partir des IDs
    if (!empty($cart)) {
        $productIds = array_keys($cart); // Récupérer les IDs des produits
        $products = $entitymanager->getRepository(Produits::class)->findBy(['id' => $productIds]);
    }
    $productById = [];
    foreach ($products as $product){
        $productById[$product->getId()] =  $product;
        $productById[$product->getPrix()] = $product;
    }

    return $this->render('cart/index.html.twig', [
        'cart' => $cart,
        'productById' => $productById,
        // dd($product)
    ]);
}

#[Route('/cart/mov/{id}', name: 'cart_mov')]

public function removeFromCart(int $id)    
{

    $this->cartService->removeProduits($id);
    if (isset($cart[$id])) {
        unset($cart[$id]);
    }


    return $this->redirectToRoute('cart_show');
}
   
}
