<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Email',
                    'class' => 'form-control',
                ],
            ])
            // ->add('username')
            // ->add('password')
            ->add('firstName', TypeTextType::class, [
                'label' => 'First Name',
                'attr' => [
                    'placeholder' => 'Prénom',
                    'class' => 'form-control',
                ],
            ])
            ->add('lastName', TypeTextType::class, [
                'label' => 'Last Name',
                'attr' => [
                    'placeholder' => 'Nom',
                    'class' => 'form-control',
                ],
            ])
            ->add('birthAt', DateType::class,[
                'label' => 'Birth Date',
                'widget' => 'single_text',
                'attr' => [
                    'placeholder' => 'Date de naissance',
                    'class' => 'form-control',
                ],
            ])
            ->add('gender', EntityType::class, [
                'class' => 'App\Entity\Gender',
                'choice_label' => 'type',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            // ->add('postalAddress')
            ->add('submit', SubmitType::class, [
                'label' => 'Sauvegarder',
                'attr' => [
                    'class' => 'button my-3',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
