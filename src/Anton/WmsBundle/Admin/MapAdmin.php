<?

namespace Anton\WmsBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;

class MapAdmin extends BaseAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('coordinate', 'text', [
                'label' => 'Координата',
            ])
            ->add('product', 'sonata_type_model', [
                'label' => 'Товар',
                'attr' => array(
                    'readonly' => true,
                    'disabled' => true
                ),
                'by_reference' => false,
                'btn_add' => false,
                'required' => false,
                'disabled' => false
            ]);;
    }
}