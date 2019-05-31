<?php

namespace App\Form\Type;

use App\Entity\Companies;
use App\Entity\ProjectCompanies;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectCompaniesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('companies', EntityType::class,[
                'class' => Companies::class,
                'choice_label' => 'companie_name'
            ])
            ->add('gotProject', CheckboxType::class,[
                'label' => false,
                'required' => false,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProjectCompanies::class,
        ]);
    }
}
