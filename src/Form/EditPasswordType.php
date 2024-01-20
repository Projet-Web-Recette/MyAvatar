<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class EditPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'minlength' => 8,
                    'maxlength' => 30,
                    'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)[a-zA-Z\\d]{8,30}$'
                ],
                'constraints' => [
                    new NotBlank(),
                    new NotNull(),
                    new Length(
                        min: 8,
                        max: 30,
                        minMessage: "Le mot de passe doit contenir au moins {{ limit }} caractères",
                        maxMessage: "Le mot de passe doit contenir au plus {{ limit }} caractères"
                    ),
                    new Regex(
                        pattern: '#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,30}$#',
                        message: 'Le mot de passe doit contenir au moins une minuscule, une majuscule et un chiffre'
                    )
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => [
                    'minlength' => 8,
                    'maxlength' => 30,
                    'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)[a-zA-Z\\d]{8,30}$'
                ],
                'constraints' => [
                    new NotBlank(),
                    new NotNull(),
                    new Length(
                        min: 8,
                        max: 30,
                        minMessage: "Le mot de passe doit contenir au moins {{ limit }} caractères",
                        maxMessage: "Le mot de passe doit contenir au plus {{ limit }} caractères"
                    ),
                    new Regex(
                        pattern: '#^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,30}$#',
                        message: 'Le mot de passe doit contenir au moins une minuscule, une majuscule et un chiffre'
                    )
                ]
            ])
            ->add('register', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
