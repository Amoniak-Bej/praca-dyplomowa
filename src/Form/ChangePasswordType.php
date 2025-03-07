<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currentPassword', PasswordType::class, [
                'label' => 'Aktualne hasło',
                'mapped' => false,
                'constraints' => [
                    new UserPassword(['message' => 'Podane hasło jest nieprawidłowe'])
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Nowe hasło',
                    'attr' => ['class' => 'form-control']
                ],
                'second_options' => [
                    'label' => 'Powtórz nowe hasło',
                    'attr' => ['class' => 'form-control']
                ],
                'mapped' => false,
                'constraints' => [
                    new NotBlank(['message' => 'Hasło nie może być puste']),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Hasło musi mieć co najmniej {{ limit }} znaków'
                    ])
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Zmień hasło',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
