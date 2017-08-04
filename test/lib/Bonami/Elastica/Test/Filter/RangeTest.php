<?php
namespace Bonami\Elastica\Test\Filter;

use Bonami\Elastica\Filter\Range;
use Bonami\Elastica\Test\Base as BaseTest;

class RangeTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testAddField()
    {
        $rangeFilter = new Range();
        $returnValue = $rangeFilter->addField('fieldName', array('to' => 'value'));
        $this->assertInstanceOf('Bonami\Elastica\Filter\Range', $returnValue);
    }

    /**
     * @group unit
     */
    public function testToArray()
    {
        $field = 'field_name';
        $range = array('gte' => 10, 'lte' => 99);

        $filter = new Range();
        $filter->addField($field, $range);
        $expectedArray = array('range' => array($field => $range));
        $this->assertEquals($expectedArray, $filter->toArray());
    }

    /**
     * @group unit
     */
    public function testSetExecution()
    {
        $field = 'field_name';
        $range = array('gte' => 10, 'lte' => 99);
        $filter = new Range('field_name', $range);

        $filter->setExecution('fielddata');
        $this->assertEquals('fielddata', $filter->getParam('execution'));

        $returnValue = $filter->setExecution('index');
        $this->assertInstanceOf('Bonami\Elastica\Filter\Range', $returnValue);
    }

    /**
     * Tests that parent fields are not overwritten by the toArray method.
     *
     * @group unit
     */
    public function testSetCachedNotOverwritten()
    {
        $filter = new Range('field_name', array());
        $filter->setCached(true);
        $array = $filter->toArray();
        $this->assertTrue($array['range']['_cache']);
    }
}
