<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewBookForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('class',ChoiceType::class,[
                'choices'=>[
                    '1'=>'1',
                    '2'=>'2',
                    '3'=>'3',
                    '4'=>'4'
                ],
                'label'=>'Class(Form)'

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'app_bundle_new_book_form';
    }
}
