<?php

namespace App\Form;

use App\Entity\Transports;
use App\Entity\Uber;
use App\Entity\Cars;
use App\Repository\UberRepository;
use App\Repository\CarsRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotEqualTo;


class TransportsType extends AbstractType
{
    private $uberRepository;
    private $carRepository;
    public function __construct(
        UberRepository $uberRepository,
        CarsRepository $carRepository
    ) {
        $this->UberRepository = $uberRepository;
        $this->CarsRepository = $carRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type',ChoiceType::class, [
                'choices' => array(
                    'Uber' => 'uber',
                    'Car' => 'car',
                ),
                'label' => 'Choice type',
                'required' => true,

            ])
            ->add('etat_transport',ChoiceType::class, [
                'choices' => array(
                    'Active' => true,
                    'Inactive' => false,


                ),
                'attr' => ['class' => 'custom-control-label','for' => 'customSwitch3'],
                'label' => 'Status',
            ])

        ;
        $builder ->get('type')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event)
            {
                $form = $event->getForm();
                $data = $event->getData();
                $type = $data->getType();
                if($type == true){
                    $form->getParent()->add('uber',EntityType::class, [
                        'class' => Uber::class,
                        'label' => 'Ubers',
                        'placeholder' => 'Select a Uber',
                        'choices' => $form->getData()->getUber(),
                    ]);
                }
                else{
                    $form->getParent()->add('car', EntityType::class, [
                        'class' => Cars::class,
                        'label' => 'Cars',
                        'placeholder' => 'Select a Car',

                    ]);
                }

            }
        );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transports::class,
            'csrf_protection' => false
        ]);
    }
}
