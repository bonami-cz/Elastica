<?php
namespace Bonami\Elastica\Test\Exception;

use Bonami\Elastica\Document;
use Bonami\Elastica\Exception\PartialShardFailureException;
use Bonami\Elastica\Query;
use Bonami\Elastica\ResultSet;

class PartialShardFailureExceptionTest extends AbstractExceptionTest
{
    /**
     * @group functional
     */
    public function testPartialFailure()
    {
        $this->_checkScriptInlineSetting();
        $client = $this->_getClient();
        $index = $client->getIndex('elastica_partial_failure');
        $index->create(array(
            'index' => array(
                'number_of_shards' => 5,
                'number_of_replicas' => 0,
            ),
        ), true);

        $type = $index->getType('folks');

        $type->addDocument(new Document('', array('name' => 'ruflin')));
        $type->addDocument(new Document('', array('name' => 'bobrik')));
        $type->addDocument(new Document('', array('name' => 'kimchy')));

        $index->refresh();

        $query = Query::create(array(
            'query' => array(
                'filtered' => array(
                    'filter' => array(
                        'script' => array(
                            'script' => 'doc["undefined"] > 8', // compiles, but doesn't work
                        ),
                    ),
                ),
            ),
        ));

        try {
            $index->search($query);

            $this->fail('PartialShardFailureException should have been thrown');
        } catch (PartialShardFailureException $e) {
            $resultSet = new ResultSet($e->getResponse(), $query);
            $this->assertEquals(0, count($resultSet->getResults()));
        }
    }
}
