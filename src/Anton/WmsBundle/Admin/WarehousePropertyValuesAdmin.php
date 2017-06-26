<?

namespace Anton\WmsBundle\Admin;


use Sonata\AdminBundle\Form\FormMapper;


class WarehousePropertyValuesAdmin extends BaseAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('property', 'sonata_type_model_list', [
                'label' => 'Название',
                'btn_add'       => false,
                'btn_delete'    => false,
                'btn_list'    => false
            ])
            ->add('value', 'text', [
                'label' => 'Значение',
                'required' => false
            ]);
    }
}