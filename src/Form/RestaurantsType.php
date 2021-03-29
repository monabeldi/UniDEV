<?php

namespace App\Form;

use App\Entity\Restaurants;
use App\Entity\Catalogues;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RestaurantsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_rest', TextType::class, [
                'label' => 'Nom Restaurant',
            ])
            ->add('add_rest', TextType::class, [
                'label' => 'Adresse Restaurant',
            ])
            ->add('num_tel_rest', NumberType::class,[
                'label' => 'Télephone Restaurant',
                'constraints' => [new Length(['min' => 8])],
            ])
            ->add('photo_rest', FileType::class, array(
                'label' => 'Image',
                'data_class' => null,
                'required' => false
            ))
            ->add('catalogue', EntityType::class , [
                'choice_label' => 'id',
                'class' => Catalogues::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => Restaurants::class,
            'csrf_protection' => false
        ]);
    }
}
