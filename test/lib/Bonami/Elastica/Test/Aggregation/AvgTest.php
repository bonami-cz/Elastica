<?php
namespace Bonami\Elastica\Test\Aggregation;

use Bonami\Elastica\Aggregation\Avg;
use Bonami\Elastica\Document;
use Bonami\Elastica\Query;

class AvgTest extends BaseAggregationTest
{
    protected function _getIndexForTest()
    {
        $index = $this->_createIndex();

        $index->getType('test')->addDocuments(array(
            new Document(1, array('price' => 5)),
            new Document(2, array('price' => 8)),
            new Document(3, array('price' => 1)),
            new Document(4, array('price' => 3)),
        ));

        $index->refresh();

        return $index;
    }

    /**
     * @group functional
     */
    public function testAvgAggregation()
    {
        $agg = new Avg('avg');
        $agg->setField('price');

        $query = new Query();
        $query->addAggregation($agg);
        $results = $this->_getIndexForTest()->search($query)->getAggregations();
        $this->assertEquals((5 + 8 + 1 + 3) / 4.0, $results['avg']['value']);
    }
}
