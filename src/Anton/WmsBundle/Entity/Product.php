<?php

namespace Anton\WmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Anton\WmsBundle\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Product
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
     * @var string
     *
     * @ORM\Column(name="barcode", type="string", length=255)
     */
    private $barcode;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", cascade={"persist"}, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @var ProductPropertyValue[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="ProductPropertyValue",
     *      mappedBy="product",
     *      orphanRemoval=true,
     *     cascade={"persist"}
     * )
     */
    private $propertyValues;

    /**
     * @var Map
     *
     * @ORM\OneToOne(targetEntity="Anton\WmsBundle\Entity\Map", mappedBy="product")
     */
    private $map;

    /**
     * @ORM\PrePersist
     * @Orm\PreUpdate
     */
    public function lifecycle()
    {
        $properties = $this->getCategory()->getProperties();
        foreach ($properties as $property) {
            $propertyValue = new ProductPropertyValue();
            $propertyValue->setProperty($property);
            $this->addPropertyValue($propertyValue);
        }
    }

    public function __construct()
    {
        $this->propertyValues = new ArrayCollection();
    }

    public function __toString()
    {
        return ($this->name) ?: '';
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
     * @return Product
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

    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getBarcode()
    {
        return $this->barcode;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    public function getPropertyValues()
    {
        return $this->propertyValues;
    }

    public function addPropertyValue(ProductPropertyValue $propertyValue)
    {
        $this->propertyValues->add($propertyValue);
        $propertyValue->setProduct($this);

        return $this;
    }

    public function removePropertyValue(ProductPropertyValue $propertyValue)
    {
        $this->propertyValues->removeElement($propertyValue);

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

    public function getMap()
    {
        return $this->map;
    }

    public function setMap(Map $map)
    {
        $map->setProduct($this);
        $this->map = $map;

        return $this;
    }

    public function removeMap()
    {
        $this->map->setProduct(null);
        $this->map = null;

        return $this;
    }
}

