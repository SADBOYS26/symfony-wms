<?

namespace Anton\WmsBundle\Admin;


use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class WarehouseAdmin extends BaseAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('name', 'text', [
                'label' => 'Название',
                'required' => false
            ])
            ->add('category', 'sonata_type_model_list', [
                'label' => 'Категория',
                'btn_delete' => false
            ])
            ->add('propertyValues', 'sonata_type_collection', array(
                'label' => 'Значения свойств',
                'btn_add' => false,
                'type_options' => array(
                    'delete' => false,
                    'delete_options' => array(
                        'type'         => 'hidden',
                        'type_options' => array(
                            'mapped'   => false,
                            'required' => false,
                        )
                    )
                )
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
            ))
            ->add('maps', 'sonata_type_collection', array(
                'label' => 'Карта',
                'by_reference' => false,
                'type_options' => array(
                    'delete' => false
                )
            ), array(
                'edit' => 'inline',
                'inline' => 'table',
                'sortable' => 'position',
            ));
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

        parent::configureListFields($listMapper);
        $listMapper
            ->add('name', 'text', [
                'label' => 'Название'
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
            ->add('propertyValues', 'sonata_type_model', [
                'label' => 'Значения свойств',
                'multiple' => true
            ]);
    }
}