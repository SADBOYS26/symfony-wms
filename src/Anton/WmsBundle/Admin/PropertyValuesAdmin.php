<?

namespace Anton\WmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class PropertyValuesAdmin extends AbstractAdmin
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