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
                'label' => false,
                'class' => Companies::class,
                'choice_label' => 'companie_name',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('gotProject', CheckboxType::class,[
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
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
