<?

namespace Anton\WmsBundle\Admin;

use Sonata\AdminBundle\Form\FormMapper;

class MapAdmin extends BaseAdmin
{
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('coordinate', 'text', [
                'label' => 'Координата'
            ]);
    }
}