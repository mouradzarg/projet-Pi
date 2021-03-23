<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,['required'=>true,'constraints'=>[new Length(['min'=>4,'minMessage'=>'le nom doit etre supérieure à 4 caractére'])],])
            ->add('prenom',TextType::class,['required'=>true,'constraints'=>[new Length(['min'=>4,'minMessage'=>'le prenom doit etre supérieure à 4 caractére'])],])
            ->add('email')
            ->add('numTel')
            ->add('password',PasswordType::class,['required'=>true,'constraints'=>[new Length(['min'=>8,'minMessage'=>'le password doit etre supérieure à 8 caractére'])],])
            ->add('cin',TextType::class,['required'=>true,'constraints'=>[new Length(['min'=>8,'minMessage'=>'le nom doit etre supérieure à 8 caractére'])],])
            ->add('dateNaiss')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
