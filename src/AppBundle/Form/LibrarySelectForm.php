<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LibrarySelectForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('book', EntityType::class, [
                'class' => 'AppBundle:Metadata',
                'query_builder' => function (EntityRepository $er)  {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.title', 'ASC');
                },
                'choice_label' => 'meta',
                'required'=>true,
                'label'=>'Book',
                'placeholder'=>'Select Book'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'app_bundle_library_select_form';
    }
}
