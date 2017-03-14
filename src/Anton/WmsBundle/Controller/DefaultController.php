<?php

namespace Anton\WmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AntonWmsBundle:Default:index.html.twig');
    }
}
