<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('studentName',null,[
                
            ])
            ->add('admissionNumber',null,[
                
            ])
            ->add('status',ChoiceType::class,[
                'choices'=>[
                    'Active'=>'Active',
                    'Suspended'=>'Suspended',
                    'Transferred'=>'Transferred'
                ],
                
            ])
            ->add('currentClass',null,[
                'label'=>'Current Class (Form)'
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Student'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_student_form';
    }
}
