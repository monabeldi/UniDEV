<?php

namespace App\Form;

use App\Entity\Boutique;
use App\Entity\Produit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Produit1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomProduit',TextType::class)
            ->add('marqueProduit',TextType::class)
            ->add('prixProduit',TextType::class)
            ->add('photoProduit',FileType::class,array('label' => 'Image',
                'data_class' => null,
                'required' => false))

            ->add('boutique',EntityType::class,array(
                'class'=> Boutique::class ,'label' => 'Boutique', 'choice_label' => 'nomBoutique' ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
