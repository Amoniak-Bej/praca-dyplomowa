<?php

namespace App\Form;

use App\Entity\TransportOrder;
use App\Enum\Currency;
use App\Enum\LoadType;
use App\Enum\TransportOrderStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class TransportOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fromStreet', TextType::class, [
                'label' => 'Ulica (adres od)',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Podaj ulicę!'])
                ]
            ])
            ->add('fromPostalCode', TextType::class, [
                'label' => 'Kod pocztowy (adres od)',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Podaj kod pocztowy!'])
                ]
            ])
            ->add('fromCity', TextType::class, [
                'label' => 'Miasto (adres od)',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Podaj miasto!'])
                ]
            ])
            ->add('fromCountry', TextType::class, [
                'label' => 'Kraj (adres od)',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Podaj kraj!'])
                ]
            ])
            ->add('toStreet', TextType::class, [
                'label' => 'Ulica (adres do)',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Podaj ulicę!'])
                ]
            ])
            ->add('toPostalCode', TextType::class, [
                'label' => 'Kod pocztowy (adres do)',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Podaj kod pocztowy!'])
                ]
            ])
            ->add('toCity', TextType::class, [
                'label' => 'Miasto (adres do)',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Podaj miasto!'])]
            ])
            ->add('toCountry', TextType::class, [
                'label' => 'Kraj (adres do)',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Podaj kraj!'])]
            ])
            ->add('loadingDateTime', DateTimeType::class, [
                'label' => 'Data i godzina załadunku',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control datetimepicker'],
                'constraints' => [
                    new NotBlank(['message' => 'Podaj datę i godzinę załadunku!'])]
            ])
            ->add('unloadingDateTime', DateTimeType::class, [
                'label' => 'Data i godzina rozładunku',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control datetimepicker'],
                'constraints' => [
                    new NotBlank(['message' => 'Podaj datę i godzinę rozładunku!'])]
            ])->add('loadType', ChoiceType::class, [
                'label' => 'Rodzaj ładunku',
                'choices' => array_combine(
                    array_map(fn($enum) => $enum->label(), LoadType::cases()),
                    LoadType::cases()
                ),
                'attr' => ['class' => 'form-select'],
                'constraints' => [
                    new NotBlank(['message' => 'Wybierz rodzaj ładunku!'])]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Cena',
                'currency' => false,
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Podaj cenę!'])
                ]
            ])
            ->add('currency', ChoiceType::class, [
                'label' => 'Waluta',
                'choices' => array_combine(
                    array_map(fn($enum) => $enum->label(), Currency::cases()),
                    Currency::cases()
                ),
                'attr' => ['class' => 'form-select'],
                'constraints' => [new NotBlank(['message' => 'Wybierz walutę!'])]
            ])
            ->add('companyName', TextType::class, [
                'label' => 'Nazwa firmy',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Podaj nazwę firmy!'])
                ]
            ])
            ->add('companyNip', TextType::class, [
                'label' => 'NIP firmy',
                'attr' => ['class' => 'form-control'],
                'required' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Podaj nip firmy!'])
                ]
            ])
            ->add('companyStreet', TextType::class, [
                'label' => 'Ulica firmy',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Podaj ulicę firmy!'])
                ]
            ])
            ->add('companyPostalCode', TextType::class, [
                'label' => 'Kod pocztowy firmy',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Podaj kod pocztowy firmy!'])
                ]
            ])
            ->add('companyCity', TextType::class, [
                'label' => 'Miasto firmy',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Podaj miasto firmy!'])
                ]
            ])
            ->add('companyCountry', TextType::class, [
                'label' => 'Kraj firmy',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank(['message' => 'Podaj kraj firmy!'])
                ]
            ])
            ->add('companyContactPerson', TextType::class, [
                'label' => 'Osoba kontaktowa',
                'attr' => ['class' => 'form-control'],
                'required' => false
            ])
            ->add('companyEmail', TextType::class, [
                'label' => 'Email firmy',
                'attr' => ['class' => 'form-control'],
                'required' => false,
                'constraints' => [
                    new Email(['message' => 'Podaj poprawny adres email!'])
                ]
            ])
            ->add('companyPhone', TextType::class, [
                'label' => 'Telefon firmy',
                'attr' => ['class' => 'form-control'],
                'required' => false,
                'constraints' => [
                    new Regex([
                        'pattern' => '/^\+?\d{9,15}$/',
                        'message' => 'Numer telefonu musi zawierać od 9 do 15 cyfr!'
                    ])
                ]
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'Status zlecenia',
                'choices' => array_combine(
                    array_map(fn($enum) => $enum->label(), TransportOrderStatus::cases()),
                    TransportOrderStatus::cases()
                ),
                'attr' => ['class' => 'form-select'],
                'constraints' => [new NotBlank(['message' => 'Wybierz status!'])]
            ])
            ->add('notes', TextareaType::class, [
                'label' => 'Uwagi',
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'min-height: 120px; resize: none;'
                ],
                'required' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Zapisz zlecenie',
                'attr' => ['class' => 'btn btn-primary']
            ])
            ->add('orderNumber', TextType::class, [
                'label' => 'Numer zamówienia',
                'attr' => ['class' => 'form-control', 'readonly' => true],
                'disabled' => true,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TransportOrder::class,
        ]);
    }
}
