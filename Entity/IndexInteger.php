<?php

namespace Oro\Bundle\SearchBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Integer entity for search index
 *
 * @ORM\Table(name="search_index_integer")
 * @ORM\Entity
 */
class IndexInteger
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Item", inversedBy="integerFields")
     * @ORM\JoinColumn(name="item_id", referencedColumnName="id")
     */
    private $item;

    /**
     * @var string
     *
     * @ORM\Column(name="field", type="string", length=250)
     */
    private $field;

    /**
     * @var integer
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set field name
     *
     * @param string $field
     * @return IndexInteger
     */
    public function setField($field)
    {
        $this->field = $field;
        return $this;
    }

    /**
     * Get field name
     *
     * @return string 
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * Set field value
     *
     * @param integer $value
     * @return IndexInteger
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get field value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set item
     *
     * @param Item $index
     * @return IndexInteger
     */
    public function setItem(Item $index = null)
    {
        $this->item = $index;
        return $this;
    }

    /**
     * Get item
     *
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }
}