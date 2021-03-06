<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class,[
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => false,
                    'required' => false,
                    'mapped' => false,
                ])
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
                'required' => false,
                'mapped' => false,
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => false,
                'required' => false,
                'mapped' => false,
            ])
            ->add('phone_number', TelType::class,[
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => false,
                'mapped' => false,
                'required' => false,
                'constraints' => new Assert\Regex('/^0[1-9]([-. ]?\d{2}){4}$/')
            ])
        ;
    }
}
