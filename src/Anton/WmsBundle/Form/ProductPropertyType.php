<?php

namespace Anton\WmsBundle\Form;

use Anton\WmsBundle\Entity\ProductPropertyValue;
use Anton\WmsBundle\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductPropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $m = 3;
        $builder
            ->add('value', null, ['label' => 'Значение'])
            ->add('property', EntityType::class, [
                'class' => Property::class,
                'choice_label' => 'name',
                'label' => 'Свойство',
                'disabled' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ProductPropertyValue::class,
        ));
    }
}