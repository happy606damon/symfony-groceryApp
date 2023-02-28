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
            ->add('name', TextType::class, ['label' => 'Name', 'attr' => ['class' => 'item-form-input']])
            ->add('description', TextType::class, ['label' => 'Description', 'attr' => ['class' => 'item-form-input']])
            ->add('priority', TextType::class, ['label' => 'Priority', 'attr' => ['class' => 'item-form-input']])
            ->add('create_date', DateTimeType::class, array(
                    'widget' => 'single_text',
                    'html5' => false,
                    'format' => 'yyyy-mm-dd',
                    'attr' => [
                        'class' => 'item-form-input created-form-control input-inline',
                    ]
                ))
            //->add('updated_at', DateTimeType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
