<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use App\Services\CarteServices;
use App\Services\CarteServicesInterface;
use App\Services\OrdersServicesInterface;
use App\Services\StripeServicesInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class PaymentController extends AbstractController
{

    public function __construct(
        readonly private OrdersServicesInterface $ordersServicesInterface,
        readonly private CarteServicesInterface $cartService,
        readonly private CommandeRepository $commandeRepository,
        readonly private EntityManagerInterface $entityManagerInterface,
    ){}

    #[Route("/checkout/{total}", name:"app_checkout")]
    public function index(StripeServicesInterface $stripeServicesInterface, float $total)
    { 
        $cart = $this->cartService->getCart();
        $tx = $this->ordersServicesInterface->makeOrder($total, $cart);
        return $this->redirect($stripeServicesInterface->payestripe($tx));
    }

    #[Route('/success', name: 'app_success')]
    public function success(Request $request, UrlGeneratorInterface $urlGeneratorInterface, CarteServices $carteServices)
    {
        $tx = $request->query->get("tx");
        $order = $this->commandeRepository->findOneBy(["tx"=>$tx]);
        $order->setPayer(true);
        $this->entityManagerInterface->flush();
        $carteServices->clearCart();
        $response = new Response;
        $url = $urlGeneratorInterface->generate("app_menu",[], UrlGeneratorInterface::ABSOLUTE_URL);
        $response->headers->set('Refresh', '3; url=' . $url);
        return $this->render('payment/success.html.twig', [
            $response->send(),
        ]);
    }
    #[Route('/cancel', name: 'app_cancel')]

    public function cancel()
    {
        
        return $this->render('payment/cancel.html.twig');
    }
 
  
}


