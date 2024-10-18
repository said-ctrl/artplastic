<?php



namespace App\Services;

use Symfony\Component\HttpFoundation\Session\Session;

class CarteServices implements CarteServicesInterface
{

    private $session;
    public function __construct()
    {
        $this->session = new Session();
    }
    public function addproduits($produitsId)
    {
        $cart = $this->session->get('cart', []);
        if (!isset($cart[$produitsId])) {
            $cart[$produitsId] = 1;
        } else {
            $cart[$produitsId]++;
        }
        $this->session->set('cart', $cart);
    }
    public function removeProduits($produitsId)
    {
        $cart = $this->session->get('cart', []);
        if (isset($cart[$produitsId])) {
            $cart[$produitsId]--;
            if ($cart[$produitsId] <= 0) {
                unset($cart[$produitsId]);
            }
        }
        $this->session->set('cart', $cart);
    }
    public function getCart()
    {
        return $this->session->get('cart', []);
    }


    public function clearCart()
    {
        $this->session->set('cart', []);
    }


    public function getTotal()
    {
        $cart = $this->getCart();
        $total = 0;

        foreach ($cart as $produitsId => $quantity) {
            if (isset($this->products[$produitsId])) {
                // $total += $this->products[$produitsId] * $quantity;
            }
        }

        return $total;
    }


    
}

