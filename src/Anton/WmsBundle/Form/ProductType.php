<?php

namespace Anton\WmsBundle\Form;

use Anton\WmsBundle\Entity\ProductPropertyValue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Anton\WmsBundle\Entity\Category;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('weight')
            ->add('barcode')
            ->add('propertyValues', CollectionType::class, [
                'entry_type' => ProductPropertyType::class,
                'label' => null
            ])
            ->add('add', SubmitType::class, ['label' => 'Сохранить', 'attr' => ['class' => 'product-js-edit-save']]);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Anton\WmsBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'anton_wmsbundle_product';
    }


}
