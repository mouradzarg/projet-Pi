<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',null,['label'=> 'Titre :'])
            ->add('description',null,['label'=> 'Description :'])
            ->add('adresse',null,['label'=> 'Adresse :'])
            ->add('lat',null,['label'=> 'lat :'])
            ->add('lng',null,['label'=> 'lng :'])
            ->add('ville',null,['label'=> 'Ville :'])
            ->add('prix',null,['label'=> 'Prix :'])
            ->add('date_deb',null,['label'=> 'Date Début :'])
            ->add('date_fin',null,['label'=> 'Date Fin :'])
            ->add('imageFile',FileType::class,[
                'required'=>false
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
