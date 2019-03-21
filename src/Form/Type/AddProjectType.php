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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
            ])
            ->add('adress', TextType::class, [
                'label' => 'Adress',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('postalCode', NumberType::class, [
                'label' => 'Code Postal',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('cost', NumberType::class, [
                'label' => 'Coût',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('startedAt', DateType::class, [
                'label' => 'Date de début',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('endedAt', DateType::class, [
                'label' => 'Date de Fin',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => [
                    'Etude en cours' => 1,
                    'Chantier en cours' => 2,
                    'Chantier terminé' => 3,
                ]
            ]);

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
            ''
        ]);
    }
}