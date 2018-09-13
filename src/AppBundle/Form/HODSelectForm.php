<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HODSelectForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $subject = $options['subject'];

        $builder
            ->add('book', EntityType::class, [
                'class' => 'AppBundle:Metadata',
                'query_builder' => function (EntityRepository $er) use ($subject)  {
                    return $er->createQueryBuilder('m')
                        ->andWhere('m.category = :subject')
                        ->setParameter(':subject',$subject)
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
        $resolver->setDefaults([
            'subject'=>null,

        ]);
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_hodselect_form';
    }
}
