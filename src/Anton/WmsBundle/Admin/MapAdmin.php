<?

namespace Anton\WmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class MapAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('coordinate', 'text', [
                'label' => 'Координата'
            ])
            ->add('warehouse', 'sonata_type_model', [
                'label' => 'Склад',
                'by_reference' => false,
                'expanded' => true
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('coordinate', null, [
                'label' => 'Координата'
            ])
            ->add('warehouse', null, [
                'label' => 'Склад'
            ]);
    }
    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('coordinate', 'text', [
                'label' => 'Координата'
            ])
            ->add('warehouse', 'sonata_type_model', [
                'label' => 'Склад'
            ])
            ->add('reserve', null, [
                'choices' => [
                    'Да' => true, 'Нет' => false,
                ], 'label' => 'Занят',
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
            ->add('coordinate', 'text', [
                'label' => 'Координата'
            ])
            ->add('warehouse', 'sonata_type_model', [
                'label' => 'Склад'
            ])
            ->add('reserve', null, [
                'choices' => [
                    'Да' => true, 'Нет' => false,
                ], 'label' => 'Занят',
            ]);
    }
}