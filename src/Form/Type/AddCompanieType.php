<?php

namespace App\Form\Type;

use App\Entity\Companies;
use App\Entity\CompanieType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCompanieType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companie_name', TextType::class, [
                    'label'=>'Nom de l\'Entreprise',
                    'required' => false,
                    'attr'=>[
                        'pattern' => '[A-Za-z& -.]{1,}',
                        'class'=>'form-control',
                        'Placeholder' => 'ex: Entreprise Exemple & Entreprise',
                    ]
                ])
            ->add('Adress',TextType::class, [
                    'label'=>'Adresse',
                    'required' => false,
                    'attr'=>[
                        'pattern' => '^\d{1,2}([,. -]?[A-Za-z ]{1,}){1,}([.]?$)',
                        'class'=>'form-control',
                        'Placeholder' => 'ex: 15 rue des fleurs',
                    ]
                ])
            ->add('postal_code',TextType::class, [
                    'label'=>'Code postal',
                    'required' => false,
                    'attr'=>[
                        'pattern' => '\d{5}',
                        'class'=>'form-control',
                        'Placeholder' => 'ex: 67000',
                    ]
                ])
            ->add('City',TextType::class,  [
                    'label'=>'Ville',
                    'required' => false,
                    'attr'=>[
                        'pattern' => '^[A-Z]([- ]?[A-Za-z]){1,}',
                        'class'=>'form-control',
                        'Placeholder' => 'ex: Strasbourg',
                    ]
                ])
            ->add('phone_number',TelType::class, [
                    'label'=>'Téléphone Fixe',
                    'required' => false,
                    'attr'=>[
                        'pattern' => '^0[1-68]([-. ]?\d{2}){4}$',
                        'class'=>'form-control',
                        'Placeholder' => 'ex: 99.99.99.99.99',
                    ]
                ])
            ->add('turnover',NumberType::class, [
                    'label'=>'Chiffre d\'Affaire',
                    'required' => false,
                    'attr'=>[
                        'pattern' => '\d{1,}',
                        'class'=>'form-control',
                        'Placeholder' => 'ex: 3857000',
                    ]
                ])
            ->add('social_reason',TextType::class, [
                    'label'=>'Raison Social',
                    'attr'=>[
                        'pattern' => '[A-Za-z& -.]{1,}',
                        'class'=>'form-control',
                        'Placeholder' => 'ex: ',
                    ]
                ])
            ->add('type',EntityType::class,[
                    'class' => CompanieType::class,
                    'label'=>'Activité',
                    'choice_label' => 'label',
                    'required' => false,
                    'attr'=> [
                        'class' => 'form-control'
                    ]
                ])
            ->add('unexistingType', AddCompanieTypeType::class, [
                'mapped' => false,
                'required' => false,
                'label' => false,
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Companies::class,
        ]);
    }
}
