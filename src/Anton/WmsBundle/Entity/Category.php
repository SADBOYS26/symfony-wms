<?php

namespace Anton\WmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 *
 * @ORM\Table(name="category")
 * @ORM\Entity()
 */
class Category
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
     * @var Property[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Property", inversedBy="categories", cascade={"persist"})
     * @ORM\JoinTable(name="category_property")
     */
    private $properties;

    /**
     * @var Product[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="Product",
     *      mappedBy="category",
     *      orphanRemoval=true,
     *      cascade={"persist"}
     * )
     */
    private $products;

    /**
     * @var WarehouseCategory[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Anton\WmsBundle\Entity\WarehouseCategory", cascade={"persist"})
     * @ORM\JoinTable(name="category_warehouse_category")
     */
    private $warehouseCategory;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
        $this->products = new ArrayCollection();
        $this->warehouseCategory = new ArrayCollection();
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

    public function addProperty(Property $property)
    {
        if (!$this->properties->contains($property)) {
            $this->properties->add($property);
        }

        return $this;
    }

    public function removeProperty(Property $property)
    {
        $this->properties->removeElement($property);

        return $this;
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function addWarehouseCategory(WarehouseCategory $warehouseCategory)
    {
        if (!$this->warehouseCategory->contains($warehouseCategory)) {
            $this->warehouseCategory->add($warehouseCategory);
        }

        return $this;
    }

    public function removeWarehouseCategory(WarehouseCategory $warehouseCategory)
    {
        $this->warehouseCategory->removeElement($warehouseCategory);

        return $this;
    }

    public function getWarehouseCategory()
    {
        return $this->warehouseCategory;
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function addProduct(Product $product)
    {
        $this->products->add($product);
        $product->setCategory($this);

        return $this;
    }
}

