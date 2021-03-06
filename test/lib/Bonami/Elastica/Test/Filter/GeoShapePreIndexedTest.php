<?php
namespace Bonami\Elastica\Test\Filter;

use Bonami\Elastica\Filter\AbstractGeoShape;
use Bonami\Elastica\Filter\GeoShapePreIndexed;
use Bonami\Elastica\Query\Filtered;
use Bonami\Elastica\Query\MatchAll;
use Bonami\Elastica\Test\Base as BaseTest;

class GeoShapePreIndexedTest extends BaseTest
{
    /**
     * @group functional
     */
    public function testGeoProvided()
    {
        $index = $this->_createIndex();
        $indexName = $index->getName();
        $type = $index->getType('type');
        $otherType = $index->getType('other_type');

        // create mapping
        $mapping = new \Bonami\Elastica\Type\Mapping($type, array(
            'location' => array(
                'type' => 'geo_shape',
            ),
        ));
        $type->setMapping($mapping);

        // create other type mapping
        $otherMapping = new \Bonami\Elastica\Type\Mapping($type, array(
            'location' => array(
                'type' => 'geo_shape',
            ),
        ));
        $otherType->setMapping($otherMapping);

        // add type docs
        $type->addDocument(new \Bonami\Elastica\Document('1', array(
            'location' => array(
                'type' => 'envelope',
                'coordinates' => array(
                    array(0.0, 50.0),
                    array(50.0, 0.0),
                ),
            ),
        )));

        // add other type docs
        $otherType->addDocument(new \Bonami\Elastica\Document('2', array(
            'location' => array(
                'type' => 'envelope',
                'coordinates' => array(
                    array(25.0, 75.0),
                    array(75.0, 25.0),
                ),
            ),
        )));

        $index->optimize();
        $index->refresh();

        $gsp = new GeoShapePreIndexed(
            'location', '1', 'type', $indexName, 'location'
        );
        $gsp->setRelation(AbstractGeoShape::RELATION_INTERSECT);

        $expected = array(
            'geo_shape' => array(
                'location' => array(
                    'indexed_shape' => array(
                        'id' => '1',
                        'type' => 'type',
                        'index' => $indexName,
                        'path' => 'location',
                    ),
                    'relation' => $gsp->getRelation(),
                ),
            ),
        );

        $this->assertEquals($expected, $gsp->toArray());

        $query = new Filtered(new MatchAll(), $gsp);
        $results = $index->getType('type')->search($query);

        $this->assertEquals(1, $results->count());

        $index->delete();
    }

    /**
     * @group unit
     */
    public function testSetRelation()
    {
        $gsp = new GeoShapePreIndexed('location', '1', 'type', 'indexName', 'location');
        $gsp->setRelation(AbstractGeoShape::RELATION_INTERSECT);
        $this->assertEquals(AbstractGeoShape::RELATION_INTERSECT, $gsp->getRelation());
        $this->assertInstanceOf('Bonami\Elastica\Filter\GeoShapePreIndexed', $gsp->setRelation(AbstractGeoShape::RELATION_INTERSECT));
    }
}
