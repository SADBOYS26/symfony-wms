<?php

namespace Anton\WmsBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Property
 *
 * @ORM\Table(name="property")
 * @ORM\Entity()
 */
class Property
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
     * @Assert\NotBlank()
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var Category[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Category", mappedBy="properties", cascade={"persist"})
     */
    private $categories;

    /**
     * @var ProductPropertyValue[]|ArrayCollection
     *
     * @ORM\OneToMany(
     *      targetEntity="ProductPropertyValue",
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
     * @return Property
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

