<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Animal;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use FOS\CKEditorBundle\Form\Type\CKEditorType; 

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Description',
            ])
            ->add('priceHt', NumberType::class, [
                'label' => 'Prix HT',
            ])
            ->add('isActive', ChoiceType::class, [
                'label' => 'Actif',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
            ])
            ->add('animals',CollectionType::class, [
                'label' => 'Animaux',
                'entry_type' => EntityType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'attr' => [
                    'data-list-selector' => 'animals',
                ],
                'entry_options' => [
                    'label' => false,
                    'class' => Animal::class,
                    'choice_label' => 'species',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('a')
                            ->orderBy('a.species', 'ASC');
                    },
                ],
            ])
            ->add('addAnimal', ButtonType::class, [
                'label' => 'Ajouter un animal',
                'attr' => [
                    'data-btn-selector' => 'animals',
                ],
            ])
            ->add('brand', EntityType::class, [
                'class' => 'App\Entity\Brand',
                'choice_label' => 'designation',
                'multiple' => false,
                'expanded' => false,
                'label' => 'Marque',
            ])
            ->add('category', EntityType::class, [
                'class' => 'App\Entity\Category',
                'choice_label' => 'label',
                'multiple' => false,
                'expanded' => false,
                'label' => 'Catégorie',
            ])
            ->add('picture', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File(
                        maxSize: '2048k',
                        mimeTypes: ['image/png', 'image/jpeg'],
                        mimeTypesMessage: 'Ce format d\'image n\'est pas pris en compte',
                    )
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
