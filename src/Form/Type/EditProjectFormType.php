<?php

namespace App\Form\Type;

use App\Entity\Companies;
use App\Entity\Employee;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditProjectFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('projectName', TextType::class, [
                'label' => 'Nom du Projet',
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
            ->add('city', TextType::class, [
                'label' => 'Ville',
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
            ->add('cost', NumberType::class, [
                'label' => 'Coût',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
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
            ->add('companies', CollectionType::class, [
                'label' => false,
                'entry_type' => ProjectCompaniesType::class,
                'attr' => [
                    'class' => 'form-control'
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'empty_data' => null,
                'required' => false,
            ])
            ->add('contacts', CollectionType::class, [
                'label' => false,
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'label' => false,
                    'class' => Employee::class,
                    'choice_label' => function ($employee) {
                        /* @var $employee Employee */
                        return $employee->__toString();
                    },
                    'attr' => [
                        'class' => 'form-control'
                    ],
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('files', CollectionType::class, [
                'entry_type' => ProjectFileType::class,
                'required' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('projectImage', CollectionType::class,[
                'entry_type' => ProjectFileType::class,
                'allow_add' => true,
                'required' => false,
                'mapped' => false,
                'by_reference' => false,
            ])
            ->add('newCompanies', CollectionType::class,[
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'label' => false,
                    'class' => Companies::class,
                    'choice_label' => 'companie_name',
                    'attr' => [
                        'class' => 'form-control'
                    ],
                ],
                'allow_add' => true,
                'required' => false,
                'mapped' => false,
                'by_reference' => false,
            ])
            ->add('newContacts',CollectionType::class, [
                'label' => false,
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'label' => false,
                    'class' => Employee::class,
                    'choice_label' => function ($employee) {
                        /* @var $employee Employee */
                        return $employee->__toString();
                    },
                    'attr' => [
                        'class' => 'form-control'
                    ],
                ],
                'allow_add' => true,
                'mapped' => false,
                'by_reference' => false,
            ])
            ->add('newFiles', CollectionType::class,[
                'entry_type' => ProjectFileType::class,
                'required' => false,
                'allow_add' => true,
                'by_reference' => false,
                'mapped' => false,
            ])
            ->add('isGot',CheckboxType::class,[
                'label' => 'A été acquis',
                'required' => false,
                'attr' => [
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
