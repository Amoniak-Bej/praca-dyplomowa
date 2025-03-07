<?php

namespace App\Form;

use App\Entity\Trailer;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TrailerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('licenseNumber', TextType::class,[
                'label' => 'Numer rejestracyjny',
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new NotBlank(message:  'Wpisz numer rejestracyjny!')
                ]
            ])
            ->add('mileage', NumberType::class, [
                'label' => 'Przebieg',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('mileageDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Data ostatniego pobrania przebiegu',
                'attr' => ['class' => 'form-control datepicker'],
                'required' => false,
                'disabled' => true
            ])
            ->add('yearOfProduction', NumberType::class, [
                'label' => 'Rok produkcji',
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new NotBlank(message:  'Wpisz rok produkcji!')
                ]
            ])
            ->add('brand', TextType::class, [
                'label' => 'Marka',
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new NotBlank(message: 'Wpisz markę!')
                ]
            ])
            ->add('kind', TextType::class, [
                'label' => 'Rodzaj',
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new NotBlank(message: 'Wpisz rodzaj!')
                ]
            ])
            ->add('purchaseDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Data zakupu',
                'attr' => ['class' => 'form-control datepicker'],
                'required' => true,
                'constraints' => [
                    new NotBlank(message: 'Wpisz datę zakupu')
                ]
            ])
            ->add('firstRegisterDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Data pierwszej rejestracji',
                'attr' => ['class' => 'form-control datepicker'],
                'required' => true,
                'constraints' => [
                    new NotBlank(message: 'Wpisz datę pierwszej rejestacji!')
                ]
            ])
            ->add('salesDate', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Data sprzedaży',
                'required' => false,
                'attr' => ['class' => 'form-control datepicker']
            ])
            ->add('caretaker', EntityType::class, [
                'class' => User::class,
                'label' => 'Opiekun pojazdu',
                'attr' => ['class' => 'form-select select2'],
                'required' => true
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Zapisz',
                'attr' => ['class' => 'btn btn-primary']
            ])
            ->add('changedMileage', CheckboxType::class, [
                'mapped' => false,
                'row_attr' => ['class' => 'd-none']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trailer::class,
        ]);
    }
}
