<?php
namespace Bonami\Elastica\Test\Filter;

use Bonami\Elastica\Document;
use Bonami\Elastica\Filter\BoolOr;
use Bonami\Elastica\Filter\Ids;
use Bonami\Elastica\Test\Base as BaseTest;

class BoolOrTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testAddFilter()
    {
        $filter = $this->getMockForAbstractClass('Bonami\Elastica\Filter\AbstractFilter');
        $orFilter = new BoolOr();
        $returnValue = $orFilter->addFilter($filter);
        $this->assertInstanceOf('Bonami\Elastica\Filter\BoolOr', $returnValue);
    }

    /**
     * @group unit
     */
    public function testToArray()
    {
        $orFilter = new BoolOr();

        $filter1 = new Ids();
        $filter1->setIds('1');

        $filter2 = new Ids();
        $filter2->setIds('2');

        $orFilter->addFilter($filter1);
        $orFilter->addFilter($filter2);

        $expectedArray = array(
            'or' => array(
                    $filter1->toArray(),
                    $filter2->toArray(),
                ),
            );

        $this->assertEquals($expectedArray, $orFilter->toArray());
    }

    /**
     * @group unit
     */
    public function testConstruct()
    {
        $ids1 = new Ids('foo', array(1, 2));
        $ids2 = new Ids('bar', array(3, 4));

        $and1 = new BoolOr(array($ids1, $ids2));

        $and2 = new BoolOr();
        $and2->addFilter($ids1);
        $and2->addFilter($ids2);

        $this->assertEquals($and1->toArray(), $and2->toArray());
    }

    /**
     * @group functional
     */
    public function testOrFilter()
    {
        $index = $this->_createIndex();
        $type = $index->getType('test');

        $doc1 = new Document('', array('categoryId' => 1));
        $doc2 = new Document('', array('categoryId' => 2));
        $doc3 = new Document('', array('categoryId' => 3));

        $type->addDocument($doc1);
        $type->addDocument($doc2);
        $type->addDocument($doc3);

        $index->refresh();

        $boolOr = new \Bonami\Elastica\Filter\BoolOr();
        $boolOr->addFilter(new \Bonami\Elastica\Filter\Term(array('categoryId' => '1')));
        $boolOr->addFilter(new \Bonami\Elastica\Filter\Term(array('categoryId' => '2')));

        $resultSet = $type->search($boolOr);
        $this->assertEquals(2, $resultSet->count());
    }
}
