<?php


namespace App\Form\Type;


use App\Entity\CompanieType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCompanieTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('label',
            TextType::class, [
                'label'=>'Métier',
                'required' => false,
                'attr'=>[
                    'pattern' => '[A-ZÀ-ÿa-z& -.]{1,}',
                    'class'=>'form-control',
                    'Placeholder' => 'ex: Architecte',
                ]
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CompanieType::class,
        ]);
    }
}