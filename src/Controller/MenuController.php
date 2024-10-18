<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MenuController extends AbstractController
{
    #[Route('/', name: 'app_menu')]
    public function index(): Response
    {
        return $this->render('menu/index.html.twig', [
            'controller_name' => 'MenuController',
        ]);
    }
    #[Route("/cgu", name:"cgu")]
    
    public function cgu(): Response
    {
        return $this->render('cgu.html.twig');
    }

    
    #[Route("/cgv", name:"cgv")]
   
    public function cgv(): Response
    {
        return $this->render('cgv.html.twig');
    }
}
