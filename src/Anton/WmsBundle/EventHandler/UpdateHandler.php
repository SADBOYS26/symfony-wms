<?php

namespace Anton\WmsBundle\EventHandler;

use Anton\WmsBundle\Entity\Category;
use Anton\WmsBundle\Entity\Product;
use Anton\WmsBundle\Entity\ProductPropertyValue;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Symfony\Component\DependencyInjection\Container;

class UpdateHandler
{

    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();
        $entities = array_merge($uow->getScheduledEntityInsertions(), $uow->getScheduledEntityUpdates());
        foreach ($entities as $entity) {
            if ($entity instanceof Category) {
                $products = $em->getRepository(Product::class)->findBy(['category' => $entity->getId()]);
                $properties = $entity->getProperties();
                foreach ($products as $product){
                    foreach ($properties as $property){
                        if(!$product->getProperties()->contains($property)){
                            $newPropertyValue = new ProductPropertyValue();
                            $newPropertyValue->setProperty($property)->setProduct($product);
                            $em->persist($newPropertyValue);
                        }
                    }
                }
            }
        }
        $uow->computeChangeSets();
    }
}