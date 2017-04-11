<?php

namespace Anton\WmsBundle\Controller;

use Anton\WmsBundle\Entity\{
    Category, Product, ProductPropertyValue, Property, User
};
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AntonWmsBundle:Default:index.html.twig');
    }

    public function productsAction()
    {
        $products = $this->getDoctrine()->getManager()->getRepository(Product::class)->findAll();
        return $this->render('AntonWmsBundle:Default:products.html.twig', ['products' => $products]);
    }

    public function usersAction()
    {
        $users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
        return $this->render('AntonWmsBundle:Default:users.html.twig', ['users' => $users]);
    }

    public function testAction()
    {
        $em = $this->getDoctrine()->getManager();

//        $category = new Category();
//        $property = new Property();
//        $product = new Product();
//        $propertyValue = new ProductPropertyValue();
//
//        $property
//            ->setName('Срок годности');
//        $propertyValue
//            ->setProperty($property)
//            ->setValue(6);
//        $category
//            ->setName('Продукты')
//            ->addProperty($property);
//        $product
//            ->setName('Йогурт')
//            ->setWeight(500)
//            ->setCategory($category)
//            ->addPropertyValue($propertyValue)
//            ->setBarcode('asdasda');
//
//        $em->persist($product);
//        $em->flush();

//        $category = $em->getRepository(Category::class)->find(2);
//        $property = $em->getRepository(Property::class)->findBy(['name' => 'Срок годности'])[0];
//
//        $propertyValue = new ProductPropertyValue();
//        $propertyValue
//            ->setProperty($property)
//            ->setValue(10);
//        $product = new Product();
//        $product
//            ->setName('Сыр')
//            ->setWeight(1000)
//            ->setCategory($category)
//            ->addPropertyValue($propertyValue)
//            ->setBarcode('123123132');
//        $em->persist($product);
//        $em->flush();

//        $product = $em->getRepository(Product::class)->find(2);
//        $em->remove($product);
//        $em->flush();


        return $this->render('AntonWmsBundle:Default:test.html.twig');
    }
}
