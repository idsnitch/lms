<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeacherForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, [
                'class' => 'AppBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.roles = :userRole')
                        ->setParameter(':userRole','["ROLE_TEACHER"]')
                        ->orderBy('u.firstName', 'ASC');
                },
                'choice_label' => 'fullName',
                'required'=>true,
                'label'=>'User',
                'placeholder'=>'Select User'
            ])
            ->add('subject', EntityType::class, [
                'class' => 'AppBundle:Category',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.categoryName', 'ASC');
                },
                'choice_label' => 'categoryName',
                'required'=>true,
                'label'=>'Subject',
                'placeholder'=>'Select Subject'
            ])
            ->add('classTaught',null,[
                'label'=>'Class (Form)'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Teacher'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_teacher_form';
    }
}
