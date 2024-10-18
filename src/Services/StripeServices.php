<?php
namespace App\Services;

use App\Repository\ProduitsRepository;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeServices implements StripeServicesInterface{

    public function __construct(
        private string $secret_key,
        private readonly RequestStack $requestStack,
        private readonly ProduitsRepository $produitsRepository,
        private readonly UrlGeneratorInterface $urlGeneratorInterface,

    ) {}

    public function payestripe($tx){
            $session = $this->requestStack->getSession();
            $panier = $session->get('cart',[]);
            $stripe = new \Stripe\StripeClient($this->secret_key);
    
            $product = $stripe->checkout->sessions->create([
                'success_url' => $this->urlGeneratorInterface->generate("app_success", ["tx"=>$tx], UrlGeneratorInterface::ABSOLUTE_URL),
                'line_items' => [
                    $this->Loop($panier),
                ],
                'mode' => 'payment',
            ]);
            return $product->url;
        }
        private function Loop($panier){
            
            foreach($panier as $id => $qty){
                $product = $this->produitsRepository->findOneBy(['id' => $id]);
                $data["price_data"]["unit_amount"] = $product->getPrix() * 100;
                $data["price_data"]["product_data"]["name"] = $product->getNom();
                $data["price_data"]["currency"] = 'eur';
                $data["quantity"] = $qty;
                $datas[] = $data;
            }
            return $datas;
        }
     
    }


 