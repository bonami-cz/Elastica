<?php
namespace Bonami\Elastica\Test\Facet;

use Bonami\Elastica\Document;
use Bonami\Elastica\Facet\TermsStats;
use Bonami\Elastica\Query;
use Bonami\Elastica\Query\MatchAll;
use Bonami\Elastica\Test\Base as BaseTest;

class TermsStatsTest extends BaseTest
{
    /**
     * @group functional
     */
    public function testOrder()
    {
        $client = $this->_getClient();
        $index = $client->getIndex('test');
        $index->create(array(), true);
        $type = $index->getType('helloworld');

        $doc = new Document(1, array('name' => 'tom', 'paid' => 7));
        $type->addDocument($doc);
        $doc = new Document(2, array('name' => 'tom', 'paid' => 2));
        $type->addDocument($doc);
        $doc = new Document(3, array('name' => 'tom', 'paid' => 5));
        $type->addDocument($doc);
        $doc = new Document(4, array('name' => 'mike', 'paid' => 13));
        $type->addDocument($doc);
        $doc = new Document(5, array('name' => 'mike', 'paid' => 1));
        $type->addDocument($doc);
        $doc = new Document(6, array('name' => 'mike', 'paid' => 15));
        $type->addDocument($doc);

        $facet = new TermsStats('test');
        $facet->setKeyField('name');
        $facet->setValueField('paid');
        $facet->setOrder('reverse_total');

        $query = new Query();
        $query->addFacet($facet);
        $query->setQuery(new MatchAll());

        $index->refresh();

        $response = $type->search($query);
        $facets = $response->getFacets();

        $this->assertEquals(14, $facets[ 'test' ][ 'terms' ][0]['total']);
        $this->assertEquals(29, $facets[ 'test' ][ 'terms' ][1]['total']);
    }

    /**
     * @group functional
     */
    public function testQuery()
    {
        $client = $this->_getClient();
        $index = $client->getIndex('test');
        $index->create(array(), true);
        $type = $index->getType('helloworld');

        $doc = new Document(1, array('name' => 'tom', 'paid' => 7));
        $type->addDocument($doc);
        $doc = new Document(2, array('name' => 'tom', 'paid' => 2));
        $type->addDocument($doc);
        $doc = new Document(3, array('name' => 'tom', 'paid' => 5));
        $type->addDocument($doc);
        $doc = new Document(4, array('name' => 'mike', 'paid' => 13));
        $type->addDocument($doc);
        $doc = new Document(5, array('name' => 'mike', 'paid' => 1));
        $type->addDocument($doc);
        $doc = new Document(6, array('name' => 'mike', 'paid' => 15));
        $type->addDocument($doc);

        $facet = new TermsStats('test');
        $facet->setKeyField('name');
        $facet->setValueField('paid');

        $query = new Query();
        $query->addFacet($facet);
        $query->setQuery(new MatchAll());

        $index->refresh();

        $response = $type->search($query);
        $facets = $response->getFacets();

        $this->assertEquals(2, count($facets[ 'test' ][ 'terms' ]));
        foreach ($facets[ 'test' ][ 'terms' ] as $facet) {
            if ($facet[ 'term' ] === 'tom') {
                $this->assertEquals(14, $facet[ 'total' ]);
            }
            if ($facet[ 'term' ] === 'mike') {
                $this->assertEquals(29, $facet[ 'total' ]);
            }
        }
    }

    /**
     * @group unit
     */
    public function testSetSize()
    {
        $facet = new TermsStats('test');
        $facet->setSize(100);

        $data = $facet->toArray();

        $this->assertArrayHasKey('size', $data['terms_stats']);
        $this->assertEquals(100, $data['terms_stats']['size']);
    }
}
