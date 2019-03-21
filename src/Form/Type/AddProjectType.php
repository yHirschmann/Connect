<?php
/**
 * Created by PhpStorm.
 * User: MdJk
 * Date: 21/03/2019
 * Time: 10:36
 */

namespace App\Form\Type;


use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('projectName',
            TextType::class,[
                'label' => 'Nom du Projet',
                'attr' => [
                    'class' => 'form-control'
                ]
            ]
        );
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
            ''
        ]);
    }
}