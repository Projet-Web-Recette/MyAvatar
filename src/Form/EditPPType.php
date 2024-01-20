<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class EditPPType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fileProfilePicture', FileType::class, [
                'mapped' => false,
                'required' => true,
                'attr' => [
                    'accept' => 'image/png, image/jpeg',
                    'maxsize' => '10M'
                ],
                'constraints' => [
                    new File(
                        maxSize: '10M',
                        maxSizeMessage: 'Le fichier ne doit pas dépasser {{ limit }} {{ suffix }}',
                        extensions: ['png', 'jpg'],
                        extensionsMessage: 'Le fichier doit avoir une des extensions suivantes : PNG, JPG'
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
