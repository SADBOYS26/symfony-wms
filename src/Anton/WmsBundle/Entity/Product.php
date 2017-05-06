<?php

namespace Anton\WmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Anton\WmsBundle\Repository\ProductRepository")
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
     * @var float
     *
     * @ORM\Column(name="weight", type="float")
     */
    private $weight;

    /**
     * @var string
     *
     * @ORM\Column(name="barcode", type="string", length=255)
     */
    private $barcode;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", cascade={"persist"})
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

    public function __construct()
    {
        $this->propertyValues = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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

    /**
     * Set weight
     *
     * @param float $weight
     *
     * @return Product
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
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
        $propertyValue->setProduct($this);
        $this->propertyValues->add($propertyValue);

        return $this;
    }

    public function removePropertyValue(ProductPropertyValue $propertyValue)
    {
        $this->propertyValues->removeElement($propertyValue);

        return $this;
    }

    public function getProperties()
    {
        return $this->getCategory()->getProperties();
    }
}

