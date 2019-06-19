<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;

class UserEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', PasswordType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => false,
                'required' => false,
                'mapped' => false,
                'empty_data' => "",
            ])
            ->add('confirmPassword', PasswordType::class,[
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => false,
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
                'constraints' => new Regex('/^0[1-9]([-. ]?\d{2}){4}$/')
            ])
        ;
    }
}
