<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewUserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',null,[
                'label'=>'Phone Number'
            ])
            ->add('firstName')
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true, // render check-boxes
                'choices' => [
                    'Teacher' => 'ROLE_TEACHER',
                    'HOD'=> 'ROLE_HOD',
                    'Librarian' => 'ROLE_LIBRARIAN',
                    'Dean of Studies'=> 'ROLE_DEAN_STUDIES',
                    'Admin'=>'ROLE_ADMIN'
                ],
            ])
            ->add('lastName');
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'app_bundle_new_user_form';
    }
}
