<?php

namespace App\Form;

use App\Entity\Aide;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AideType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('adresse')
            ->add('category', EntityType::class, array(
                'class' =>  Category::class,
                'choice_label' => 'name',
                'expanded' => false,
                'multiple' =>false

            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Aide::class,
        ]);
    }
}
