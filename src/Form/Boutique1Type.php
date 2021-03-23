<?php

namespace App\Form;

use App\Entity\Boutique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class Boutique1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomBoutique',TextType::class )
            ->add('addressBoutiques',TextType::class)
            ->add('numTelBoutique',NumberType::class,[
                'label' => 'Télephone Boutique',
                'constraints' => [new Length(['min' => 8])],
            ])
            ->add('emailBoutique',TextType::class)
            ->add('photoBoutique',FileType::class,array('label' => 'Image',
                'data_class' => null,
                'required' => false))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Boutique::class,
            'csrf_protection' => false
        ]);
    }
}
