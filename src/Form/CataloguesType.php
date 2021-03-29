<?php

namespace App\Form;

use App\Entity\Catalogues;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CataloguesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photo_cata', FileType::class, array(
                'label' => 'Image',
                'data_class' => null,
                'required' => false))
            ->add('nom_plat', TextType::class, [
                'label' => 'Nom plat',])
            ->add('desc_plat', TextType::class, [
                'label' => 'Description plat',])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Catalogues::class,
            'csrf_protection' => false
        ]);
    }
}
