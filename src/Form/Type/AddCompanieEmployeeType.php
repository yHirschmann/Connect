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
        $builder->add('companie',EntityType::class,[
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
            'data_class' => CompanieEmployee::class,
        ]);
    }
}