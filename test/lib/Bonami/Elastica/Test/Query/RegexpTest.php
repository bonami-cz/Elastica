<?php
namespace Bonami\Elastica\Test\Query;

use Bonami\Elastica\Query\Regexp;
use Bonami\Elastica\Test\Base as BaseTest;

class RegexpTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testToArray()
    {
        $field = 'name';
        $value = 'ruf';
        $boost = 2;

        $query = new Regexp($field, $value, $boost);

        $expectedArray = array(
            'regexp' => array(
                $field => array(
                    'value' => $value,
                    'boost' => $boost,
                ),
            ),
        );

        $this->assertequals($expectedArray, $query->toArray());
    }
}
