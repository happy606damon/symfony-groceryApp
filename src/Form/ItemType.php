<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('priority', TextType::class)
            ->add('create_date', DateTimeType::class, array(
                    'widget' => 'single_text',
                    'html5' => false,
                    //'format' => 'yyyy-mm-dd',
                    'attr' => [
                        'class' => 'js-datepicker',
                    ],
                ))
            //->add('updated_at', DateTimeType::class)
            ->add('client', HiddenType::class, array(
            'data' => $options['user']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
            'user' => null
        ]);

        $resolver->setAllowedTypes('user', 'int');
    }
}
