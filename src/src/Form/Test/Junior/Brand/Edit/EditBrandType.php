<?php

namespace App\Form\Test\Junior\Brand\Edit;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class EditBrandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', IntegerType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\GreaterThan(0),
                ]
            ])
            ->add('name')
            ->add('productName')
            ->add('productSellCount')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'label' => 'Édition d\'une marque',
            'data_class' => EditBrand::class,
            'csrf_protection' => false
        ]);
    }
}
