<?php

namespace App\Form;

use App\Entity\Activities;
use App\Entity\Organisateurs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivitiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_activite')
            ->add('lieu_evenement')
            ->add('prix_participation')
            ->add('date_debut')
            ->add('date_fin')
            ->add('heure_evenement')
            ->add('heure_fin')
            ->add('description')
            ->add('organisateur', EntityType::class, [
                'class'=>Organisateurs::class,
                'choice_label'=>'nomOrganisateur'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activities::class,
            'csrf_protection' => false
        ]);
    }
}
