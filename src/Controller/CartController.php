<?php

namespace App\Controller;

use App\Entity\CodePromo;
use App\Entity\Produits;
use App\Form\PromoCodeType;
use App\Repository\ProduitsRepository;
use App\Services\CarteServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    private $cartService;
    public function __construct(
        CarteServices $cartService,
        private readonly ProduitsRepository $produitsRepository,
    ) {
        $this->cartService = $cartService;
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]

    public function addproduits(int $id): RedirectResponse
    {
        $this->cartService->addproduits($id);
        return $this->redirectToRoute('cart_show');
    }
    #[Route('/cart', name: 'cart_show')]
    public function showCart(Request $request, EntityManagerInterface $entitymanager): Response
    {
        // Récupérer le contenu du panier
        $cart = $this->cartService->getCart();
        $products = [];
        $subtotal = 0;
        $total = 0;
        $quantity = 0;
        $productIds = 0;

        // Récupérer les détails des produits à partir des IDs
        if (!empty($cart)) {
            $productIds = array_keys($cart); // Récupérer les IDs des produits
            $products = $entitymanager->getRepository(Produits::class)->findBy(['id' => $productIds]);
        }
        $productById = [];
        foreach ($cart as $product => $quantity) {
            $prod = $this->produitsRepository->find($product);
            $subtotal  +=  $prod->getprix() * $quantity;
            $productById[$product] = $prod;
        }
        // Récupérer le code promo (par exemple, depuis une requête ou une session)
        $session = $request->getSession();
        $codePromo = $request->request->get('code_promo'); 
        $promotion = $entitymanager->getRepository(CodePromo::class)->findOneBy(['code_promo' => $codePromo]);
        $reduction = 0;
        // Appliquer la réduction si le code promo est valide
        if ($promotion) {
            $reduction = $promotion->getReduction(); // Supposons que la réduction est en pourcentage
            $total = number_format($subtotal - $subtotal * $reduction ,2,'.','',);
            // dd($reduction);
        }
        

        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
            'productById' => $productById,
            'subtotal'=> $subtotal,
            "total" => $total,
            'products' => $products,
            'quantity' => $quantity,
            'produitIds' => $productIds,
            'codePromo' => $codePromo,
            'reduction' => $reduction,


            // dd($products)
        ]);
    }
    // #[Route('/cart', name: 'cart_show')]





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
