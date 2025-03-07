<?php

namespace App\Form;

use App\Entity\Driver;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class DriverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Imię',
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Wpisz imię!'])
                ]
            ])
            ->add('surname', TextType::class, [
                'label' => 'Nazwisko',
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Wpisz nazwisko!'])
                ]
            ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Numer telefonu',
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Wpisz numer telefonu!'])
                ]
            ])
            ->add('pesel', TextType::class, [
                'label' => 'PESEL',
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Wpisz numer PESEL!']),
                    new Regex([
                        'pattern' => '/^\d{11}$/',
                        'message' => 'PESEL musi składać się z 11 cyfr.'
                    ])
                ]
            ])
            ->add('employmentDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Data zatrudnienia',
                'attr' => ['class' => 'form-control datepicker'],
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Wybierz datę zatrudnienia!'])
                ]
            ])
            ->add('terminationDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Data zwolnienia',
                'attr' => ['class' => 'form-control datepicker'],
                'required' => false
            ])
            ->add('guardian', EntityType::class, [
                'class' => User::class,
                'label' => 'Opiekun',
                'attr' => ['class' => 'form-select select2'],
                'required' => true
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Zapisz kierowcę',
                'attr' => ['class' => 'btn btn-primary']
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Driver::class,
        ]);
    }
}
