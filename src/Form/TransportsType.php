<?php

namespace App\Form;

use App\Entity\Transports;
use App\Entity\Uber;
use App\Entity\Cars;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class TransportsType extends AbstractType
{

    public function __construct(

    ) {

    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => array(
                    'Uber' => 'uber',
                    'car' => 'car'
                ),
                'placeholder' => 'Select a Type',
                'mapped' => false,
                'required' => false

            ]);
        $builder->get('type')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {

                if('type' == 'uber')
                {
                    $form = $event->getForm();
                    $this->addUberRegionField($form->getParent(), $form->getData());
            }else
                {
                    $form = $event->getForm();
                    $this->addCarRegionField($form->getParent(), $form->getData());
                }
            }


        );
        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) {
                $data = $event->getData();
                /* @var $transport Transports */
                $transport = $data;
                    $transport->getType();
                $form = $event->getForm();
                if ($transport) {
                    // On récupère le département et la région
                    $type = $transport->getType();
                    if($type == true){
                        // On crée les 2 champs supplémentaires
                        $this->addUberRegionField($form, $transport);
                        $this->addUberField($form, $type);
                        // On set les données
                        $form->get('type')->setData($transport);
                        $form->get('address_transport')->setData($transport);
                    }else
                        {
                            // On crée les 2 champs supplémentaires
                            $this->addCarRegionField($form, $transport);
                            $this->addCarField($form, $type);
                            // On set les données
                            $form->get('type')->setData($transport);
                            $form->get('address_transport')->setData($transport);
                    }

                } else {
                    // On crée les 2 champs en les laissant vide (champs utilisé pour le JavaScript)
                    $this->addCarRegionField($form, null);
                    $this->addUberField($form, null);
                }
            }
        );
    }

    private function addUberRegionField(FormInterface $form,?Uber $uber)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'address_transport',
            EntityType::class,
            null,
            [
                'class'           => 'App\Entity\Uber',
                'placeholder'     => $uber ? 'Select a type' : 'Select a region',
                'mapped'          => false,
                'required'        => false,
                'auto_initialize' => false,
                'choices'         => $uber ? $uber->setFieldUber() : []

            ]
        );
        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->addUberRegionField($form->getParent(), $form->getData());
            }
        );
                $form->add($builder->getForm());
    }
    private function addCarRegionField(FormInterface $form,?Cars $cars)
    {
        $builder = $form->getConfig()->getFormFactory()->createNamedBuilder(
            'address_car',
            EntityType::class,
            null,
            [
                'class'           => 'App\Entity\Cars',
                'placeholder'     => $cars ? 'Select a type' : 'Select a region',
                'mapped'          => false,
                'required'        => false,
                'auto_initialize' => false,
                'choices'         => $cars ? $cars->setAddressCar() : []

            ]
        );
        $builder->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                $this->addCarRegionField($form->getParent(), $form->getData());
            }
        );
                $form->add($builder->getForm());
    }
    private function addCarField(FormInterface $form, ?Cars $cars)
    {
        $form->add('car', EntityType::class, [
            'class'       => 'App\Entity\Cars',
            'placeholder' => $cars ? 'Select a Car' : 'Sélectionnez votre département',
            'choices'     => $cars ? $cars->getMarqueCar() : []
        ]);
    }
    private function addUberField(FormInterface $form, ?Uber $uber)
    {
        $form->add('uber', EntityType::class, [
            'class'       => 'App\Entity\Uber',
            'placeholder' => $uber ? 'Select a Car' : 'Sélectionnez votre département',
            'choices'     => $uber ? $uber->getNomUber() : []
        ]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transports::class,
            'csrf_protection' => false
        ]);
    }

}

       /* ->addEventListener(FormEvents::POST_SUBMIT,

            function (FormEvent $event){
                $type = $event->getData();
                $form = $event->getForm();
                if($type == 'car'){
                    $form->getParent()->add('uber',EntityType::class, [
                        'class' => Uber::class,
                        'label' => 'Ubers',
                        'placeholder' => 'Select a Uber',
                        'choices' => $form->getData()->getUber()->getNomUber(),
                    ]);
                }
                elseif($type == 'uber'){
                    $form->getParent()->add('car', EntityType::class, [
                        'class' => Cars::class,
                        'label' => 'Cars',
                        'placeholder' => 'Select a Car',
                        'choices' => $form->getData()->getCar(),

                    ]);


                }
            })
        ;
            ->add('type',ChoiceType::class, [
                'choices' => array(
                    'Uber' => true,
                    'Car' => false,


                ),
                'placeholder'=>'Select Type',
                'required' => true,

            ])
            ->add('etat_transport',ChoiceType::class, [
                'choices' => array(
                    'Active' => 'car',
                    'Inactive' => 'uber',


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
                console.log($type);
                if($type == 'uber'){
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
                        'choices' => $form->getData()->getCars(),

                    ]);
                }

            }
        );*/


