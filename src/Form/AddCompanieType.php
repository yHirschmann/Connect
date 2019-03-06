<?php

namespace App\Form;

use App\Entity\Companies;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCompanieType extends AbstractType
{
    private $transformer;


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companie_name',
                TextType::class, [
                    'label'=>'Nom de l\'Entreprise',
                    'attr'=>[
                        'pattern' => '[A-Za-z&]{1,}',
                        'class'=>'form-control',
                        'Placeholder' => 'ex: Entreprise Exemple & Entreprise',
                    ]
                ])
            ->add('Adress',
                TextType::class, [
                    'label'=>'Adresse',
                    'attr'=>[
                        'pattern' => '^\d{1,2}([. ]?[A-Za-z ]{1,}){1,}([.]?$)',
                        'class'=>'form-control',
                        'Placeholder' => 'ex: 15 rue des fleurs',
                    ]
                ])
            ->add('postal_code',
                TextType::class, [
                    'label'=>'Code postal'
                    , 'attr'=>[
                        'pattern' => '\d{5}',
                        'class'=>'form-control',
                        'Placeholder' => 'ex: 67000',
                    ]
                ])
            ->add('City',
                TextType::class,  [
                    'label'=>'Ville',
                    'attr'=>[
                        'pattern' => '^[A-Z]([- ]?[A-Za-z]){1,}',
                        'class'=>'form-control',
                        'Placeholder' => 'ex: Strasbourg',
                    ]
                ])
            ->add('phone_number',
                TelType::class, [
                    'label'=>'Téléphone Fixe',
                    'required'   => false,
                    'attr'=>[
                        'pattern' => '^0[1-68]([-. ]?\d{2}){4}$',
                        'class'=>'form-control',
                        'Placeholder' => 'ex: 99.99.99.99.99',
                    ]
                ])
            ->add('turnover',
                IntegerType::class, [
                    'label'=>'Chiffre d\'Affaire',
                    'required'   => false,
                    'attr'=>[
                        'pattern' => '',
                        'class'=>'form-control',
                        'Placeholder' => 'ex: 3857000',
                    ]
                ])
            ->add('social_reason',
                TextType::class, [
                    'label'=>'Raison Social',
                    'attr'=>[
                        'pattern' => '[A-Za-z&]{1,}',
                        'class'=>'form-control',
                        'Placeholder' => 'ex: Electricien',
                    ]
                ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Companies::class,
        ]);
    }
}