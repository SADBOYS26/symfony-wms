<?php

namespace Anton\WmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductPropertyValue
 *
 * @ORM\Table(name="warehouse_property_value")
 * @ORM\Entity()
 */
class WarehousePropertyValue
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
     * @ORM\Column(name="value", type="string", length=255, nullable=true)
     */
    private $value;


    /**
     * @var Warehouse
     *
     * @ORM\ManyToOne(targetEntity="Anton\WmsBundle\Entity\Warehouse", cascade={"persist"}, inversedBy="propertyValues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $warehouse;

    /**
     * @var WarehouseProperty
     *
     * @ORM\ManyToOne(targetEntity="Anton\WmsBundle\Entity\WarehouseProperty", cascade={"persist"}, inversedBy="propertyValues")
     * @ORM\JoinColumn(nullable=false)
     */
    private $property;

    public function __toString()
    {
        return ($this->value) ? $this->property->getName() . ' : ' . $this->getValue() : '';
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return WarehousePropertyValue
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
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

    public function getProperty()
    {
        return $this->property;
    }

    public function setProperty(WarehouseProperty $property)
    {
        $this->property = $property;

        return $this;
    }
}

