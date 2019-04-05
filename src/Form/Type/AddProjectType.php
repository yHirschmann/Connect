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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('projectName',TextType::class,[
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
                        'class' => 'form-control'
                    ]
                ])
                ->add('statut', ChoiceType::class, [
                    'choices' => [
                        'Etude en cours' => 1,
                        'Chantier en cours' => 2,
                        'Chantier terminé' => 3,
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
                ->add('unexistingCompanies', CollectionType::class, [
                        'entry_type' => AddCompanieType::class,
                        'required' => false,
                        'entry_options' => ['label' => false],
                        'label' => false,
                        'allow_add' => true,
                        'by_reference' => false,
                        'mapped' => false,
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
                ->add('imgFile', FileType::class, [
                    'label' => 'Photo du projet',
                ]);
    //TODO Add files of the project
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}