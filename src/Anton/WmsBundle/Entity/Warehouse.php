<?php

namespace Anton\WmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Warehouse
 *
 * @ORM\Table(name="warehouse")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Warehouse
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
    private $name;

    /**
     * @var WarehouseCategory
     *
     * @ORM\ManyToOne(targetEntity="Anton\WmsBundle\Entity\WarehouseCategory", cascade={"persist"}, inversedBy="warehouse")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @var WarehousePropertyValue[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="Anton\WmsBundle\Entity\WarehousePropertyValue",
     *      mappedBy="warehouse",
     *      orphanRemoval=true,
     *     cascade={"persist"}
     * )
     */
    private $propertyValues;

    /**
     * @var Map[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="Anton\WmsBundle\Entity\Map",
     *      mappedBy="warehouse",
     *      orphanRemoval=true,
     *     cascade={"all"}
     * )
     */
    private $maps;

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
     * Set name
     *
     * @param string $name
     *
     * @return Warehouse
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @ORM\PrePersist
     * @Orm\PreUpdate
     */
    public function lifecycle()
    {
        $properties = $this->getCategory()->getProperties();
        foreach ($properties as $property) {
            $propertyValue = new WarehousePropertyValue();
            $propertyValue->setProperty($property);
            $this->addPropertyValue($propertyValue);
        }
    }

    public function __construct()
    {
        $this->propertyValues = new ArrayCollection();
        $this->maps = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name ?: '';
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(WarehouseCategory $category)
    {
        $this->category = $category;

        return $this;
    }

    public function getPropertyValues()
    {
        return $this->propertyValues;
    }

    public function addPropertyValue(WarehousePropertyValue $propertyValue)
    {
        $this->propertyValues->add($propertyValue);
        $propertyValue->setWarehouse($this);

        return $this;
    }

    public function removePropertyValue(WarehousePropertyValue $propertyValue)
    {
        $this->propertyValues->removeElement($propertyValue);

        return $this;
    }

    public function getMaps()
    {
        return $this->maps;
    }

    public function addMaps(Map $map)
    {
        $map->setWarehouse($this);
        $this->maps->add($map);

        return $this;
    }

    public function removeMaps(Map $map)
    {
        $this->maps->removeElement($map);

        return $this;
    }

    public function getProperties()
    {
        $props = new ArrayCollection();
        foreach ($this->getPropertyValues() as $propertyValue) {
            $props->add($propertyValue->getProperty());
        }
        return $props;
    }
}