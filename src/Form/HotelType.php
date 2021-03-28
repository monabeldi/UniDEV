<?php

namespace App\Form;

use App\Entity\Hotel;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('idhotel',TextType::class,[
                'label'=>'Id Hotel',
                'attr'=>[
                    'placeholder'=>'Merci de saisie le id du Hotel',
                    'class'=>'idhotel'
                ]
            ])
            ->add('nomhotel',TextType::class,[
                'label'=>'Nom Hotel',
                'attr'=>[
                    'placeholder'=>'Merci de saisie le nom du Hotel',
                    'class'=>'nomhotel'
                ]
            ])
            ->add('adrrhotel',TextType::class,[
                'label'=>'Adressse Hotel',
                'attr'=>[
                    'placeholder'=>'Merci de saisie un adresse du hotel',
                    'class'=>'adrrhotel'
                ]
            ])
            ->add('photohotel',FileType::class ,array('label' => 'Image',
                'data_class' => null,
                'required' => false
                          ))




            ->add('ratehotel')
            ->add('deschotel')
            ->add('prixnuit')
            ->add('numtelhotel')
            ->add('idchambre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hotel::class,
            'csrf_protection' => false
        ]);
    }
}
