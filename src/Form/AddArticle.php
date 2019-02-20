<?php
/**
 * Created by PhpStorm.
 * User: MadJoke
 * Date: 22/01/2019
 * Time: 14:01
 */

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class AddArticle extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ProjName', TextType::class, [
                'label' => false,
                'attr' => [
                    'id' => 'prj-Name-lbl',
                    'class' => 'form-control',
                    'name' => 'prj-name',
                    'placeholder' => 'Nom du Projet',
                    'aria-label1' => 'Nom du Projet',
                ],
            ])
            ->add('ProjStatut', ChoiceType::class,[
                'label' => 'Statut du projet',
                'choices' => [
                    'Etude en cours' => 'study',
                    'En chantier' => 'uc',
                    'Terminé' => 'finished',
                ],
                'attr' => [
                    'id' => 'select-proj-statut',
                    'class' => 'custom-select',
                ],
            ])
        ;
    }

}