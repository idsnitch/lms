<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeanSwapForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $subject = $options['subject'];
        $class = $options['class'];


        $builder
            ->add('student1', EntityType::class, [
                'class' => 'AppBundle:Student',
                'query_builder' => function (EntityRepository $er) use ($class)  {
                    return $er->createQueryBuilder('t')
                        ->andWhere('t.currentClass = :class')
                        ->setParameter(':class',$class)
                        ->orderBy('t.admissionNumber', 'ASC');
                },
                'choice_label' => 'admissionNumber',
                'required'=>true,
                'label'=>'Transfer From',
                'placeholder'=>'Select Student'
            ])
            ->add('student2', EntityType::class, [
                'class' => 'AppBundle:Student',
                'query_builder' => function (EntityRepository $er) use ($class)  {
                    return $er->createQueryBuilder('t')
                        ->andWhere('t.currentClass = :class')
                        ->setParameter(':class',$class)
                        ->orderBy('t.admissionNumber', 'ASC');
                },
                'choice_label' => 'admissionNumber',
                'required'=>true,
                'label'=>'Transfer To',
                'placeholder'=>'Select Student'
            ])
            ->add('book', EntityType::class, [
                'class' => 'AppBundle:Book',
                'query_builder' => function (EntityRepository $er) use ($subject,$class)  {
                    return $er->createQueryBuilder('b')
                        ->innerJoin('b.metadata','m')
                        ->innerJoin('m.category','c')
                        ->andWhere('b.stage = :stage')
                        ->setParameter(':stage','Student')
                        ->andWhere('b.state = :state')
                        ->setParameter(':state','Active')
                        ->andWhere('c.categoryName = :category')
                        ->setParameter(':category',$subject)
                        ->andWhere('m.class = :class')
                        ->setParameter(':class',$class)
                        ->orderBy('b.barcode', 'ASC');
                },
                'choice_label' => 'barcode',
                'required'=>true,
                'label'=>'Book',
                'placeholder'=>'Select Book'
            ]);
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
        return 'app_bundle_dean_swap_form';
    }
}
