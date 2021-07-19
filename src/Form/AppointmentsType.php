<?php

namespace App\Form;

use App\Entity\Appointments;
use App\Entity\Patients;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class AppointmentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startTime',DateTimeType::class,[
                'label' => 'Heure de début du rendez-vous : ',
                'label_attr'=>['class' => 'form-label'],
                'attr'=>['class' => 'form-control']
            ])
            ->add('endTime',DateTimeType::class,[
                'label' => 'Heure de fin du rendez-vous : ',
                'label_attr'=>['class' => 'form-label'],
                'attr'=>['class' => 'form-control']
            ])
            ->add('Patients',EntityType::class,[
                'mapped' => true,                // looks for choices from this entity
                'class' => Patients::class,               
                'choice_label' => function ($patients){
                    return strtoupper($patients->getLastname()) . ' ' . $patients->getFirstname();
                }, // uses the User.username property as the visible option string
                'placeholder' => 'Choisir le patient',
                // used to render a select box, check boxes or radios
                //'multiple' => true,
                //'expanded' => true,   
                'label' => 'Choisir le Patient : ',
                'label_attr'=>['class' => 'form-label'],
                'attr'=>['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Appointments::class,
        ]);
    }
}
