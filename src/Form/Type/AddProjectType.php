<?php
/**
 * Created by PhpStorm.
 * User: MdJk
 * Date: 21/03/2019
 * Time: 10:36
 */

namespace App\Form\Type;


use App\Entity\Companies;
use App\Entity\CompanieType;
use App\Entity\Employee;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddProjectType extends AbstractType
{
    //TODO Add files of the project
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('projectName',TextType::class,[
                'label' => 'Nom du Projet',
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
                ->add('adress', TextType::class, [
                    'label' => 'Adresse',
                    'required' => false,
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
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ])
                ->add('startedAt', DateType::class, [
                    'label' => 'Date de début',
                    'widget' => 'single_text',
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ])
                ->add('endedAt', DateType::class, [
                    'label' => 'Date de Fin',
                    'widget' => 'single_text',
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control',
                        'readonly' => true,
                    ]
                ])
                ->add('phase', ChoiceType::class, [
                    'choices' => [
                        'Etude' => 0,
                        'Avant projet sommaire' => 1,
                        'Avant projet détaillé' => 2,
                        'Chantier en cour' => 3,
                        'Terminé' => 4,
                    ],
                    'attr' => [
                        'class' => 'form-control'
                    ]
                ])
                ->add('companies', CollectionType::class,[
                    'label' => false,
                    'entry_type' => EntityType::class,
                    'entry_options' => [
                        'label' => false,
                        'class'=> Companies::class,
                        'choice_label' => 'companie_name',
                        'attr' => [
                            'class' => 'form-control'
                        ],
                    ],
                    'allow_add' => true,
                    'by_reference' => false,
                    'empty_data' => null,
                    'required' => false,
                ])
                ->add('contacts', CollectionType::class,[
                    'label' => false,
                    'entry_type' => EntityType::class,
                    'entry_options' => [
                        'label' => false,
                        'class'=> Employee::class,
                        'choice_label' => function($employee){
                            return $employee->__toString();
                        },
                        'attr' => [
                            'class' => 'form-control'
                        ],
                    ],
                    'allow_add' => true,
                    'by_reference' => false,
                ])
                ->add('unexistingContacts', CollectionType::class, [
                    'entry_type' => AddContactType::class,
                    'entry_options' => ['label' => false],
                    'label' => false,
                    'required' => false,
                    'allow_add' => true,
                    'by_reference' => false,
                    'mapped' => false,
                ])
                ->add('imageFile', FileType::class, [
                    'label' => 'Photo du projet',
                    'required' => false,
                ]);

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}