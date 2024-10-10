<?php

namespace App\Form;

use App\Entity\InformationUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformationUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom', TextType::class, [
                'attr' => [
                    'class' => 'text-black',
                ]
            ])
            ->add('Prenom', TextType::class,[
                'attr' => [
                    'class' => 'text-black',
                ]
            ])
            ->add('Adresse', TextareaType::class,[
                'attr' => [
                    'class' => 'text-black',
                ]
            ])
            ->add('ville', TextType::class, [
                'attr' => [
                    'class' => 'text-black',
                ]
            ])
            ->add('CodePostal', NumberType::class, [
                'attr' => [
                    'class' => 'text-black',
                ]
            ])
            ->add('photo', FileType::class,['mapped' => false,])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InformationUser::class,
            // Configure your form options here
        ]);
    }
}
