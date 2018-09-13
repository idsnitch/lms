<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HODIssueTeacherForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $subject = $options['subject'];
        $class = $options['class'];

        $builder
            ->add('teacher', EntityType::class, [
                'class' => 'AppBundle:Teacher',
                'query_builder' => function (EntityRepository $er) use ($subject,$class)  {
                    return $er->createQueryBuilder('t')
                        ->innerJoin('t.user','user')
                        ->andWhere('user.roles = :userRole')
                        ->setParameter(':userRole','["ROLE_TEACHER"]')
                        ->andWhere('t.classTaught = :class')
                        ->setParameter(':class',$class)
                        ->andWhere('t.subject = :subject')
                        ->setParameter(':subject',$subject)
                        ->orderBy('user.firstName', 'ASC');
                },
                'choice_label' => 'user.fullName',
                'required'=>true,
                'label'=>'Teacher',
                'placeholder'=>'Select Teacher'
            ])
            ->add('numberOfBooks',IntegerType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'subject'=>null,
            'class'=>null
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_hodissue_teacher_form';
    }
}
