<?php
namespace Bonami\Elastica\Filter;

/**
 * Prefix filter.
 *
 * @author Jasper van Wanrooy <jasper@vanwanrooy.net>
 *
 * @link http://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-prefix-filter.html
 */
class Prefix extends AbstractFilter
{
    /**
     * Holds the name of the field for the prefix.
     *
     * @var string
     */
    protected $_field = '';

    /**
     * Holds the prefix string.
     *
     * @var string
     */
    protected $_prefix = '';

    /**
     * Creates prefix filter.
     *
     * @param string $field  Field name
     * @param string $prefix Prefix string
     */
    public function __construct($field = '', $prefix = '')
    {
        $this->setField($field);
        $this->setPrefix($prefix);
    }

    /**
     * Sets the name of the prefix field.
     *
     * @param string $field Field name
     *
     * @return $this
     */
    public function setField($field)
    {
        $this->_field = $field;

        return $this;
    }

    /**
     * Sets the prefix string.
     *
     * @param string $prefix Prefix string
     *
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->_prefix = $prefix;

        return $this;
    }

    /**
     * Converts object to an array.
     *
     * @see \Bonami\Elastica\Filter\AbstractFilter::toArray()
     *
     * @return array data array
     */
    public function toArray()
    {
        $this->setParam($this->_field, $this->_prefix);

        return parent::toArray();
    }
}
