<?php

namespace Anton\WmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="map")
 * @ORM\Entity()
 */
class Map
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $coordinate;

    /**
     * @var Warehouse
     *
     * @ORM\ManyToOne(targetEntity="Anton\WmsBundle\Entity\Warehouse", cascade={"persist"}, inversedBy="maps")
     * @ORM\JoinColumn(nullable=false)
     */
    private $warehouse;

    /**
     * @var Product
     *
     * @ORM\OneToOne(targetEntity="Anton\WmsBundle\Entity\Product", inversedBy="map")
     */
    private $product;

    public function getId()
    {
        return $this->id;
    }

    public function __toString()
    {
        return $this->coordinate ? $this->coordinate . ' на складе ' . $this->warehouse->getName() : '';
    }

    public function __construct()
    {
        $this->reserve = false;
    }

    /**
     * Set name
     *
     * @param string $coordinate
     *
     * @return Map
     */
    public function setCoordinate($coordinate)
    {
        $this->coordinate = $coordinate;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getCoordinate()
    {
        return $this->coordinate;
    }

    public function getWarehouse()
    {
        return $this->warehouse;
    }

    public function setWarehouse(Warehouse $warehouse)
    {
        $this->warehouse = $warehouse;

        return $this;
    }

    public function setProduct($product)
    {
        $this->product = $product;

        return $this;
    }

    public function getProduct()
    {
        return $this->product;
    }
}