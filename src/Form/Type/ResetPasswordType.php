<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passes doivent correspondre.',
                'options' =>[
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => false,
                ],
                'first_options'  => [
                    'label' => 'Nouveau mot de passe',
                    'empty_data' => "",
                    'constraints' => [
                        new Assert\Regex([
                            'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$.,!%*?&])[A-Za-z\d@$.,!%*?&]{8,}$/',
                            'message' => 'Le mot de passe doit comptenir au minimum : 8 caractères, 1 majuscule, 1 minuscule, 1 caractère spécial (ex : @$.,!%*?&)'
                        ]),
                    ]
                ],
                'second_options' => [
                    'label' => 'Répéter le mot de passe',
                    'empty_data' => "",
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
