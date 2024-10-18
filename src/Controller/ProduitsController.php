<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\Produits;
use App\Form\CommentaireType;
use App\Form\RechercheType;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProduitsController extends AbstractController
{

    public function __construct(
        readonly private ProduitsRepository $produitsRepository,
    ){}

    #[Route('/produits', name: 'app_produits')]

    public function afficheproduits(EntityManagerInterface $entity, Request $request): Response
    {
        $produits = $entity->getRepository(Produits::class)->findAll();

        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $produits = $this->produitsRepository->search($form->get("query")->getData());
        }

        return $this->render('produits/index.html.twig', [
            'controller_name' => 'MainController',
            'produit' => $produits,
            "form"=>$form,
        ]);
    }
    #[Route('/prod/{id}', name: 'app_prod')]


    public function prod($id, Request $request, EntityManagerInterface $entity): Response
    {
        $prods = $entity->getRepository(Produits::class)->findOneBy(['id' => $id]);
        $comment = new Comments();
        $form = $this->createForm(CommentaireType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setProduits($prods);
            $comment->setUser($this->getUser());
            $comment->setDateCreation(new \DateTime());

            $entity->persist($comment);
            $entity->flush();

            $this->addFlash('success', 'Commentaire ajouté avec succès!');
            return $this->redirectToRoute('app_prod', ['id' => $prods->getId()]);
        }

        return $this->render('produits/index2.html.twig', [
            'id' => $id,
            'prod' => $prods,
            'form' => $form,
        ]);
    }
    #[Route('/prod3d/{id}', name: 'app_prod3d')]
    public function prod3d($id, EntityManagerInterface $entity): Response
    {
        $prod3d = $entity->getRepository(Produits::class)->findOneBy(['id' => $id]);
        if (!$prod3d) {
            throw $this->createNotFoundException('Produit non trouvé.');
        }

        return $this->render('produits/index3.html.twig', [
            'id' => $id,
            'prod3d' => $prod3d
        ]);
    }
}
