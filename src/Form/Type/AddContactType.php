<?php
/**
 * Created by PhpStorm.
 * User: MdJk
 * Date: 18/03/2019
 * Time: 10:51
 */

namespace App\Form\Type;

use App\Entity\Companies;
use App\Entity\Employee;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $option){
        $builder
            ->add('LastName',TextType::class, [
                    'label'=>'Nom',
                    'required' => true,
                    'attr' =>[
                        'pattern' => '^[A-Z]([\-\ ]?[A-zÀ-ÿ]{1,}){1,}\D$',
                        'class'=>'form-control',
                    ]
                ])
            ->add('FirstName',TextType::class,[
                    'label'=>'Prénom',
                    'required' => true,
                    'attr' =>[
                        'pattern' => '^[A-Z]([\-\ ]?[A-zÀ-ÿ]{1,}){1,}\D$',
                        'class'=>'form-control',
                    ]
                ])
            ->add('Email',EmailType::class, [
                        'label'=>'Email',
                        'required' => true,
                        'attr' =>[
                            'pattern' => '(?(DEFINE)
                                            (?<addr_spec> (?&local_part) @ (?&domain) )
                                            (?<local_part> (?&dot_atom) | (?&quoted_string) | (?&obs_local_part) )
                                            (?<domain> (?&dot_atom) | (?&domain_literal) | (?&obs_domain) )
                                            (?<domain_literal> (?&CFWS)? \[ (?: (?&FWS)? (?&dtext) )* (?&FWS)? \] (?&CFWS)? )
                                            (?<dtext> [\x21-\x5a] | [\x5e-\x7e] | (?&obs_dtext) )
                                            (?<quoted_pair> \\ (?: (?&VCHAR) | (?&WSP) ) | (?&obs_qp) )
                                            (?<dot_atom> (?&CFWS)? (?&dot_atom_text) (?&CFWS)? )
                                            (?<dot_atom_text> (?&atext) (?: \. (?&atext) )* )
                                            (?<atext> [a-zA-Z0-9!#$%&\'*+\/=?^_`{|}~-]+ )
                                            (?<atom> (?&CFWS)? (?&atext) (?&CFWS)? )
                                            (?<word> (?&atom) | (?&quoted_string) )
                                            (?<quoted_string> (?&CFWS)? " (?: (?&FWS)? (?&qcontent) )* (?&FWS)? " (?&CFWS)? )
                                            (?<qcontent> (?&qtext) | (?&quoted_pair) )
                                            (?<qtext> \x21 | [\x23-\x5b] | [\x5d-\x7e] | (?&obs_qtext) )
                                            # comments and whitespace
                                            (?<FWS> (?: (?&WSP)* \r\n )? (?&WSP)+ | (?&obs_FWS) )
                                            (?<CFWS> (?: (?&FWS)? (?&comment) )+ (?&FWS)? | (?&FWS) )
                                            (?<comment> \( (?: (?&FWS)? (?&ccontent) )* (?&FWS)? \) )
                                            (?<ccontent> (?&ctext) | (?&quoted_pair) | (?&comment) )
                                            (?<ctext> [\x21-\x27] | [\x2a-\x5b] | [\x5d-\x7e] | (?&obs_ctext) )
                                            # obsolete tokens
                                            (?<obs_domain> (?&atom) (?: \. (?&atom) )* )
                                            (?<obs_local_part> (?&word) (?: \. (?&word) )* )
                                            (?<obs_dtext> (?&obs_NO_WS_CTL) | (?&quoted_pair) )
                                            (?<obs_qp> \\ (?: \x00 | (?&obs_NO_WS_CTL) | \n | \r ) )
                                            (?<obs_FWS> (?&WSP)+ (?: \r\n (?&WSP)+ )* )
                                            (?<obs_ctext> (?&obs_NO_WS_CTL) )
                                            (?<obs_qtext> (?&obs_NO_WS_CTL) )
                                            (?<obs_NO_WS_CTL> [\x01-\x08] | \x0b | \x0c | [\x0e-\x1f] | \x7f )
                                            # character class definitions
                                            (?<VCHAR> [\x21-\x7E] )
                                            (?<WSP> [ \t] ))
                                        ^(?&addr_spec)$',
                            'class'=>'form-control',
                        ]
                    ])
            ->add('phoneNumber',TelType::class, [
                        'label'=>'Téléphone',
                        'required' => true,
                        'attr' =>[
                            'pattern' => '^0[1-8]([-. ]?\d{2}){4}$',
                            'class'=>'form-control',
                        ]
                    ])
            ->add('position', TextType::class,[
                    'label'=>'Poste',
                    'required' => true,
                    'attr' =>[
                        'pattern' => '^[A-Z]([\-\ ]?[A-zÀ-ÿ]{1,}){1,}\D$',
                        'class'=>'form-control',
                    ]
            ])
            ->add('companie',EntityType::class,[
                'class' => Companies::class,
                'label' => 'Entreprise',
                'choice_label' => 'companie_name',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Employee::class,
        ]);
    }
}