<?

namespace Anton\WmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class WarehousePropertyAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('name', 'text', [
                'label' => 'Название'
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('name', null, [
                'label' => 'Название'
            ]);
    }
    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('name', 'text', [
                'label' => 'Название'
            ])
            ->add('categories', 'sonata_type_model', [
                'label' => 'Категории',
                'by_reference' => false,
                'multiple' => true
            ])
            ->add('_action', null, [
                'label' => ' ',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ]);
    }
    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('name', 'text', [
                'label' => 'Название'
            ])
            ->add('categories', 'sonata_type_model', [
                'label' => 'Категории',
                'by_reference' => false,
                'multiple' => true
            ]);
    }
}