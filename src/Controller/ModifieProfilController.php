<?php

namespace App\Controller;

use App\Entity\InformationUser;
use App\Form\InformationUserType;
use App\Repository\InformationUserRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ModifieProfilController extends AbstractController
{
    public function __construct(
        private readonly InformationUserRepository $informationUserRepository,
        private readonly SluggerInterface $sluggerInterface,
        private readonly UserRepository $userRepository,
    ) {}

    #[Route('/modifie/profil/{id}', name: 'app_modifie_profil')]
    public function index(Request $request, EntityManagerInterface $em, int $id, #[Autowire('%kernel.project_dir%/public/images/profil')] string $imageDirectory): Response
    {
        // verification de l'utilisateur
        $verifyUser = $this->userRepository->findOneBy(['id' => $id]);
        if ($this->getUser()->getUserIdentifier() != $verifyUser->getEmail()) {
            return $this->redirectToRoute('app_profil');
        };
        // on verifie que la ligne existe en base de donnee
        $infos = $this->informationUserRepository->findOneBy(['user' => $id]);
        if (!$infos) {
            $infos = new InformationUser;
        }

        $form = $this->createForm(InformationUserType::class, $infos);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $infos->setUser($this->getUser());
            // upload d'image
            $imageProfil = $form->get('photo')->getData();
            if ($imageProfil) {
                $originalFilename = pathinfo($imageProfil->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $this->sluggerInterface->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageProfil->guessExtension();
                try {
                    $imageProfil->move($imageDirectory, $newFilename);
                } catch (FileException $e) {
                }

                $infos->setPhoto($newFilename);
            }
            $em->persist($infos);
            $em->flush();

            $this->addFlash("sucess", "Vos infos on été changés");
            return $this->redirectToRoute("app_profil");
        }
        return $this->render('modifie_profil/index.html.twig', [
            'controller_name' => 'ModifieProfilController',
            'form' => $form,
        ]);
    }
}
