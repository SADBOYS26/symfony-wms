<?

namespace Anton\WmsBundle\Admin;

use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class ProductAdmin extends BaseAdmin
{

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('name', 'text', [
                'label' => 'Название',
                'required' => false
            ])
            ->add('barcode', 'text', [
                'label' => 'Штрихкод'
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
            ));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('name', null, [
                'label' => 'Название'
            ])
            ->add('category', null, [
                'label' => 'Категория'
            ]);
    }
    protected function configureListFields(ListMapper $listMapper): void
    {
        parent::configureListFields($listMapper);
        $listMapper
            ->add('name', 'text', [
                'label' => 'Название'
            ])
            ->add('category', 'sonata_type_model_list', [
                'label' => 'Категория'
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
            ->add('category', 'sonata_type_model_list', [
                'label' => 'Категория'
            ])
            ->add('propertyValues', 'sonata_type_collection', [
                'label' => 'Значения свойств'
            ])
            ->add('map', 'text', ['label' => 'Место на складе']);
    }
}