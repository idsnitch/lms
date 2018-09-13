<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MetadataForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
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
            ->add('title',null,[
                
            ])
            ->add('edition',ChoiceType::class,[
                'choices'=>[
                    'First Edition'=>'First Edition',
                    'Second Edition'=>'Second Edition',
                    'Third Edition'=>'Third Edition',
                    'Fourth Edition'=>'Fourth Edition',
                    'Fifth Edition'=>'Fifth Edition',
                    'Sixth Edition'=>'Sixth Edition',
                    'Seventh Edition'=>'Seventh Edition',
                    'Eighth Edition'=>'Eighth Edition',
                    'Ninth Edition'=>'Ninth Edition',
                    'Tenth Edition'=>'Tenth Edition'
                ],
                'placeholder'=>'Please Select',
                'label'=>'Edition'
            ])
            ->add('class',ChoiceType::class,[
                'choices'=>[
                    '1'=>'1',
                    '2'=>'2',
                    '3'=>'3',
                    '4'=>'4',
                ],
                'placeholder'=>'Please Select',
                'label'=>'Form'
            ])
            ->add('bookType',ChoiceType::class,[
                'choices'=>[
                    'Library Book'=>'Library Book',
                    'Course Book'=>'Course Book',
                    'Teacher\'s Guide'=>'Teacher\'s Guide',
                    'Revision Material'=>'Revision Material',
                    'Reference Books'=>'Reference Books'
                ],
                'placeholder'=>'Please Select',
                'label'=>'Type Of Book'
            ])
            ->add('author',null,[
                'required'=>true
            ])
            ->add('author2',TextareaType::class,[
                'label'=>'Other Authors'

            ])
            ->add('publisher',null,[
                'required'=>true
            ])
            ->add('yearPublished',null,[
                'required'=>true
            ])
            ->add('isbn',null,[
                'required'=>true
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Metadata'
        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_book_form';
    }
}
