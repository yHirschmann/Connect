<?php
/**
 * Created by PhpStorm.
 * User: MdJk
 * Date: 22/03/2019
 * Time: 09:59
 */

namespace App\Form\Type;


use App\Entity\Companies;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddProjectCompanieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('companies', EntityType::class, [
            'class' => Companies::class,
            'label' => 'Entreprise',
            'choice_label' => 'companie_name',
            'attr' => [
                'class' => 'form-control'
            ],
        ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}