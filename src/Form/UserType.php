<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Nazwa użytkownika',
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Wpisz nazwę użytkownika!']),
                    new Length(['min' => 3, 'max' => 180, 'minMessage' => 'Nazwa użytkownika musi mieć co najmniej 3 znaki.'])
                ]
            ])
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
            ->add('email', EmailType::class, [
                'label' => 'Adres e-mail',
                'attr' => ['class' => 'form-control'],
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Wpisz adres e-mail!']),
                    new Length(['max' => 255, 'maxMessage' => 'Adres e-mail nie może być dłuższy niż 255 znaków.'])
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Hasło',
                'attr' => ['class' => 'form-control'],
                'required' => !$options['is_edit'],
                'constraints' => $options['is_edit'] ? [] : [
                    new NotBlank(['message' => 'Wpisz hasło!']),
                    new Length(['min' => 6, 'minMessage' => 'Hasło musi mieć co najmniej 6 znaków.']),
                    new Regex([
                        'pattern' => '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/',
                        'message' => 'Hasło musi zawierać co najmniej jedną literę i jedną cyfrę.'
                    ])
                ],
                'mapped' => false
            ])

            ->add('roles', ChoiceType::class, [
                'label' => 'Uprawnienia użytkownika',
                'attr' => [
                    'class' => 'form-select custom-multiple-select',
                ],
                'choices' => [
                    'Użytkownik' => 'ROLE_USER',
                    'Administrator' => 'ROLE_ADMIN',
                    'Zarządzanie pojazdami' => 'ROLE_MANAGE_VEHICLES',
                    'Zarządzanie kierowcami' => 'ROLE_MANAGE_DRIVERS',
                    'Zarządzanie rezerwacjami' => 'ROLE_MANAGE_RESERVATIONS',
                    'Zarządzanie zleceniami transportowymi' => 'ROLE_MANAGE_TRANSPORT_ORDERS'
                ],
                'expanded' => false,
                'multiple' => true
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Zapisz użytkownika',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'is_edit' => false
        ]);
    }
}
