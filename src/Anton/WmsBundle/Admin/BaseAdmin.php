<?php

namespace Anton\WmsBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;

class BaseAdmin extends AbstractAdmin
{
    protected function configureListFields(ListMapper $listMapper): void
    {
        $this->showMosaicButton(false);
    }

    public function getExportFormats()
    {
        return ['xml'];
    }

}