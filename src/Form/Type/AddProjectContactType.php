<?php


namespace App\Form\Type;


use App\Entity\Employee;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddProjectContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('contacts', EntityType::class, [
            'class' => Employee::class,
            'label' => 'Contactes',
            'choice_label' => function($employee){
                return $employee->__toString();
            },
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