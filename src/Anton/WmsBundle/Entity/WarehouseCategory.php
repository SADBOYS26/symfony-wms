<?php

namespace Anton\WmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="warehouse_category")
 * @ORM\Entity()
 */
class WarehouseCategory
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var WarehouseProperty[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Anton\WmsBundle\Entity\WarehouseProperty", inversedBy="categories", cascade={"persist"})
     * @ORM\JoinTable(name="warehouse_category_property")
     */
    private $properties;

    /**
     * @var Warehouse[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="Anton\WmsBundle\Entity\Warehouse",
     *      mappedBy="category",
     *      orphanRemoval=true,
     *      cascade={"persist"}
     * )
     */
    private $warehouse;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
        $this->warehouse = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name ?: '';
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function addProperty(WarehouseProperty $property)
    {
        if (!$this->properties->contains($property)) {
            $this->properties->add($property);
        }

        return $this;
    }

    public function removeProperty(WarehouseProperty $property)
    {
        $this->properties->removeElement($property);

        return $this;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function getWarehouse()
    {
        return $this->warehouse;
    }

    public function addProduct(Warehouse $warehouse)
    {
        $this->warehouse->add($warehouse);
        $warehouse->setCategory($this);

        return $this;
    }
}

