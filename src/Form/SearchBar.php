<?php
/**
 * Created by PhpStorm.
 * User: MadJoke
 * Date: 22/01/2019
 * Time: 11:03
 */

namespace App\Form;


use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchBar extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', SearchType::class, [
                'label' => false,
                'required' => false,
                'attr' =>[
                    'class' => 'form-control form-control-dark',
                    'placeholder' => 'Recherche',
                    'aria-label' => 'Recherche',
                ],
            ])
            ->setMethod('GET');
    }
}