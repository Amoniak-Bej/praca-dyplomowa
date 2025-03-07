<?php

namespace App\Form;

use App\Entity\Driver;
use App\Entity\Reservation;
use App\Entity\Trailer;
use App\Entity\User;
use App\Entity\Vehicle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('driver', EntityType::class, [
                'class' => Driver::class,
                'label' => 'Kierowca',
                'placeholder' => 'Wybierz kierowcę',
                'attr' => ['class' => 'form-select'],
                'constraints' => [new NotBlank(['message' => 'Wybierz kierowcę!'])]
            ])
            ->add('vehicle', EntityType::class, [
                'class' => Vehicle::class,
                'label' => 'Pojazd',
                'placeholder' => 'Wybierz pojazd',
                'attr' => ['class' => 'form-select'],
                'constraints' => [new NotBlank(['message' => 'Wybierz pojazd!'])]
            ])
            ->add('trailer', EntityType::class, [
                'class' => Trailer::class,
                'label' => 'Naczepa',
                'placeholder' => 'Wybierz naczepę',
                'attr' => ['class' => 'form-select'],
                'required' => false
            ])
            ->add('startDate', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Data rozpoczęcia',
                'required' => true,
                'attr' => ['class' => 'form-control datetimepicker'],
                'constraints' => [
                    new NotBlank(['message' => 'Wybierz datę rozpoczęcia!'
                    ])
                ]
            ])
            ->add('endDate', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Data zakończenia',
                'attr' => ['class' => 'form-control datetimepicker'],
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Wybierz datę zakończenia!'])
                ]
            ])
            ->add('startMileage', IntegerType::class, [
                'label' => 'Przebieg przy rozpoczęciu',
                'attr' => ['class' => 'form-control'],
                'constraints' => [new NotBlank(['message' => 'Podaj przebieg!'])]
            ])
            ->add('endMileage', IntegerType::class, [
                'label' => 'Przebieg przy zakończeniu',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Zapisz rezerwację',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
