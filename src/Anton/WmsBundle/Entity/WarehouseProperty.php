<?php

namespace Anton\WmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/** *
 * @ORM\Table(name="warehouse_property")
 * @ORM\Entity()
 */
class WarehouseProperty
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
     * @var WarehouseCategory[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Anton\WmsBundle\Entity\WarehouseCategory", mappedBy="properties", cascade={"persist"})
     */
    private $categories;

    /**
     * @var WarehousePropertyValue[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="Anton\WmsBundle\Entity\WarehousePropertyValue",
     *      mappedBy="property",
     *      orphanRemoval=true,
     *      cascade={"persist"}
     * )
     */
    private $propertyValues;

    public function __toString()
    {
        return ($this->name) ?: '';
    }

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->propertyValues = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return WarehouseProperty
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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

    public function getCategories()
    {
        return $this->categories;
    }
}

