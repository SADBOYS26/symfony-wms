<?php

namespace Anton\WmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductPropertyValue
 *
 * @ORM\Table(name="product_property_value")
 * @ORM\Entity(repositoryClass="Anton\WmsBundle\Repository\ProductPropertyValueRepository")
 */
class ProductPropertyValue
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
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @var Property
     *
     * @ORM\ManyToOne(targetEntity="Property", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $property;

    public function __toString()
    {
        return $this->property->getName() . ' : ' . $this->getValue();
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
     * @return ProductPropertyValue
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

    public function getProduct()
    {
        return $this->product;
    }

    public function setProduct(Product $product)
    {
        $this->product = $product;

        return $this;
    }

    public function getProperty()
    {
        return $this->property;
    }

    public function setProperty(Property $property)
    {
        $this->property = $property;

        return $this;
    }
}

