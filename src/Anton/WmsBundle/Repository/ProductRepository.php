<?php

namespace Anton\WmsBundle\Repository;

use Anton\WmsBundle\Entity\Product;
use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository
{
    /**
     * @return Product[]|array
     */
    public function getMappedProduct()
    {
        $db = $this->createQueryBuilder('p');
        return $db->select('p')->leftJoin('p.map', 'm')->where('m.product IS NOT NULL')->getQuery()->getResult();
    }
}