<?php
namespace Bonami\Elastica\Test;

use Bonami\Elastica\Document;
use Bonami\Elastica\Result;
use Bonami\Elastica\Test\Base as BaseTest;

class ResultSetTest extends BaseTest
{
    /**
     * @group functional
     */
    public function testGetters()
    {
        $index = $this->_createIndex();
        $type = $index->getType('test');

        $type->addDocuments(array(
            new Document(1, array('name' => 'elastica search')),
            new Document(2, array('name' => 'elastica library')),
            new Document(3, array('name' => 'elastica test')),
        ));
        $index->refresh();

        $resultSet = $type->search('elastica search');

        $this->assertInstanceOf('Bonami\Elastica\ResultSet', $resultSet);
        $this->assertEquals(3, $resultSet->getTotalHits());
        $this->assertGreaterThan(0, $resultSet->getMaxScore());
        $this->assertInternalType('array', $resultSet->getResults());
        $this->assertEquals(3, count($resultSet));
    }

    /**
     * @group functional
     */
    public function testArrayAccess()
    {
        $index = $this->_createIndex();
        $type = $index->getType('test');

        $type->addDocuments(array(
            new Document(1, array('name' => 'elastica search')),
            new Document(2, array('name' => 'elastica library')),
            new Document(3, array('name' => 'elastica test')),
        ));
        $index->refresh();

        $resultSet = $type->search('elastica search');

        $this->assertInstanceOf('Bonami\Elastica\ResultSet', $resultSet);
        $this->assertInstanceOf('Bonami\Elastica\Result', $resultSet[0]);
        $this->assertInstanceOf('Bonami\Elastica\Result', $resultSet[1]);
        $this->assertInstanceOf('Bonami\Elastica\Result', $resultSet[2]);

        $this->assertFalse(isset($resultSet[3]));
    }

    /**
     * @group functional
     * @expectedException \Bonami\Elastica\Exception\InvalidException
     */
    public function testInvalidOffsetCreation()
    {
        $index = $this->_createIndex();
        $type = $index->getType('test');

        $doc = new Document(1, array('name' => 'elastica search'));
        $type->addDocument($doc);
        $index->refresh();

        $resultSet = $type->search('elastica search');

        $result = new Result(array('_id' => 'fakeresult'));
        $resultSet[1] = $result;
    }

    /**
     * @group functional
     * @expectedException \Bonami\Elastica\Exception\InvalidException
     */
    public function testInvalidOffsetGet()
    {
        $index = $this->_createIndex();
        $type = $index->getType('test');

        $doc = new Document(1, array('name' => 'elastica search'));
        $type->addDocument($doc);
        $index->refresh();

        $resultSet = $type->search('elastica search');

        return $resultSet[3];
    }
}
