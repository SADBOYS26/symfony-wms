<?php

namespace Anton\WmsBundle\Controller;

use Anton\WmsBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();

        return $this->render('AntonWmsBundle:Default:index.html.twig', ['users' => $users]);
    }
}
