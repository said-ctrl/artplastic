<?php

namespace App\Services;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class OrdersServices implements OrdersServicesInterface
{

    public function __construct(
        readonly private CommandeRepository $commandeRepository,
        readonly private ProduitsRepository $produitsRepository,
        readonly private EntityManagerInterface $entityManagerInterface,
        readonly private Security $security,
    ) {}


    public function makeOrder($total, $panier)
    {
        $order = new Commande();
        $user = $this->security->getUser();

        if ($user) {
            $order->setUser($user);
        }

        $order->setDatecommande(new \DateTime());
        $order->setPrixTotal($total);
        $order->setTx(uniqid());
        $order->setPayer(false);

        foreach ($panier as $key => $quantity) {
            $produit = $this->produitsRepository->find($key);
            $order->addProduit($produit);
        }
        $this->entityManagerInterface->persist($order);
        $this->entityManagerInterface->flush();

        return $order->getTx();
    }
}
