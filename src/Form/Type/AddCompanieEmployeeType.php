<?php
/**
 * Created by PhpStorm.
 * User: MdJk
 * Date: 19/03/2019
 * Time: 10:20
 */

namespace App\Form\Type;

use App\Entity\CompanieEmployee;
use App\Entity\Companies;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCompanieEmployeeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('companie',
            EntityType::class,[
                'class' => Companies::class,
                'label' => 'Entreprise',
                'choice_label' => 'companie_name',
                'attr' => [
                  'class' => 'form-control'
                ],
            ])
            ->add('enter_at',
                DateType::class,[
                    'choice_translation_domain' => true,
                    'label' => 'Date d\'entrée',
                    'widget' => 'single_text',
                    'attr' => [
                        'class'=> 'form-control'
                    ]
                ])
            ->add('out_at',
                DateType::class,[
                    'data' => new \DateTime('9999-1-1'),
                    'choice_translation_domain' => true,
                    //'label' => 'Date de sortie (optionnel)',
                    'label' => false,
                    'widget' => 'single_text',
                    'required' => false,
                    'attr' => [
                        'class'=> 'form-control',
                        'hidden' => true,
                        //'disabled'=> true,
                    ]
                ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CompanieEmployee::class,
            ''
        ]);
    }
}