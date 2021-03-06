<?php
namespace Bonami\Elastica\Test\Filter;

use Bonami\Elastica\Filter\Exists;
use Bonami\Elastica\Test\Base as BaseTest;

class ExistsTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testToArray()
    {
        $field = 'test';
        $filter = new Exists($field);

        $expectedArray = array('exists' => array('field' => $field));
        $this->assertEquals($expectedArray, $filter->toArray());
    }

    /**
     * @group unit
     */
    public function testSetField()
    {
        $field = 'test';
        $filter = new Exists($field);

        $this->assertEquals($field, $filter->getParam('field'));

        $newField = 'hello world';
        $this->assertInstanceOf('Bonami\Elastica\Filter\Exists', $filter->setField($newField));

        $this->assertEquals($newField, $filter->getParam('field'));
    }
}
