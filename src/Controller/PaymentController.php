<?php

namespace App\Controller;

use App\Services\StripeServicesInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{
    #[Route("/checkout", name:"app_checkout")]
    public function index(StripeServicesInterface $stripeServicesInterface)
    { 
        return $this->redirect($stripeServicesInterface->payestripe());
    }

    #[Route('/success', name: 'app_success')]
    public function success()
    {

        return $this->render('payment/index.html.twig', [
            
        ]);
    }
    


}
