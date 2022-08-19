<?php

namespace App\Form\Filter;

use App\Entity\User;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\ChoiceFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\DateRangeFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Factory\Cache\ChoiceFilter;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
            ])
            ->add('username', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
            ])
            ->add('roles', filtertype::class, [
                'choices' => [
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                ],
            ])
            ->add('firstName', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
            ])
            ->add('lastName', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
            ])
            ->add('birthAt', DateRangeFilterType::class, [
                'left_date_options' => [
                    'label' => 'De',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                ],
                'right_date_options' => [
                    'label' => 'à',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                ],
            ])
            ->add('createdAt', DateRangeFilterType::class, [
                'left_date_options' => [
                    'label' => 'De',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
                ],
                'right_date_options' => [
                    'label' => 'à',
                    'widget' => 'single_text',
                    'format' => 'yyyy-MM-dd',
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
