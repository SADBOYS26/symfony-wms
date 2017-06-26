<?

namespace Anton\WmsBundle\Admin;


use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;

class UserAdmin extends BaseAdmin
{
    protected function getRoles()
    {
        $container = $this->getConfigurationPool()->getContainer();
        $rolesHierarchy = $container->getParameter('security.role_hierarchy.roles');
        $flatRoles = [];
        foreach ($rolesHierarchy as $key => $roles) {
            $flatRoles[$key] = $key;
            if (empty($roles)) {
                continue;
            }
            foreach($roles as $role) {
                if(!isset($flatRoles[$role])) {
                    $flatRoles[$role] = $role;
                }
            }
        }
        return $flatRoles;
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('username', 'text', [
                'label' => 'Логин'
            ])
            ->add('email', 'text', [
                'label' => 'Email'
            ])
            ->add('enabled', 'choice', [
                'choices' => [
                    'Да' => true,
                    'Нет' => false
                ],
                'label' => 'Активность'
            ])
            ->add('roles', 'choice', [
                'choices'  => $this->getRoles(),
                'multiple' => true,
                'label' => 'Права'
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('username', null, [
                'label' => 'Логин'
            ])
            ->add('email', null, [
                'label' => 'Email'
            ])
            ->add('enabled', null, [
                'choices' => [
                    'Да' => true,
                    'Нет' => false
                ],
                'label' => 'Активность'
            ]);
    }
    protected function configureListFields(ListMapper $listMapper): void
    {

        parent::configureListFields($listMapper);
        $listMapper
            ->add('username', 'text', [
                'label' => 'Логин'
            ])
            ->add('email', 'text', [
                'label' => 'Email'
            ])
            ->add('enabled', null, [
                'choices' => [
                    'Да' => true,
                    'Нет' => false
                ],
                'label' => 'Активность'
            ])
            ->add('roles', 'choice', [
                'choices'  => $this->getRoles(),
                'multiple' => true,
                'label' => 'Права'
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
            ->add('username', 'text', [
                'label' => 'Логин'
            ])
            ->add('email', 'text', [
                'label' => 'Email'
            ])
            ->add('enabled', null, [
                'choices' => [
                    'Да' => true,
                    'Нет' => false
                ],
                'label' => 'Активность'
            ])
            ->add('roles', 'choice', [
                'choices'  => $this->getRoles(),
                'multiple' => true,
                'label' => 'Права'
            ]);
    }
}