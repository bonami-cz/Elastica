<?php
namespace Bonami\Elastica\Test\Query;

use Bonami\Elastica\Query\Nested;
use Bonami\Elastica\Query\QueryString;
use Bonami\Elastica\Test\Base as BaseTest;

class NestedTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testSetQuery()
    {
        $nested = new Nested();
        $path = 'test1';

        $queryString = new QueryString('test');
        $this->assertInstanceOf('Bonami\Elastica\Query\Nested', $nested->setQuery($queryString));
        $this->assertInstanceOf('Bonami\Elastica\Query\Nested', $nested->setPath($path));
        $expected = array(
            'nested' => array(
                'query' => $queryString->toArray(),
                'path' => $path,
            ),
        );

        $this->assertEquals($expected, $nested->toArray());
    }
}
