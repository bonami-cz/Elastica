<?php
namespace Bonami\Elastica\Test\Filter;

use Bonami\Elastica\Document;
use Bonami\Elastica\Filter\AbstractGeoShape;
use Bonami\Elastica\Filter\GeoShapeProvided;
use Bonami\Elastica\Query\Filtered;
use Bonami\Elastica\Query\MatchAll;
use Bonami\Elastica\Test\Base as BaseTest;
use Bonami\Elastica\Type\Mapping;

class GeoShapeProvidedTest extends BaseTest
{
    /**
     * @group functional
     */
    public function testConstructEnvelope()
    {
        $index = $this->_createIndex();
        $type = $index->getType('test');

        // create mapping
        $mapping = new Mapping($type, array(
            'location' => array(
                'type' => 'geo_shape',
            ),
        ));
        $type->setMapping($mapping);

        // add docs
        $type->addDocument(new Document(1, array(
            'location' => array(
                'type' => 'envelope',
                'coordinates' => array(
                    array(-50.0, 50.0),
                    array(50.0, -50.0),
                ),
            ),
        )));

        $index->optimize();
        $index->refresh();

        $envelope = array(
            array(25.0, 75.0),
            array(75.0, 25.0),
        );
        $gsp = new GeoShapeProvided('location', $envelope);

        $expected = array(
            'geo_shape' => array(
                'location' => array(
                    'shape' => array(
                        'type' => GeoShapeProvided::TYPE_ENVELOPE,
                        'coordinates' => $envelope,
                    ),
                    'relation' => AbstractGeoShape::RELATION_INTERSECT,
                ),
            ),
        );

        $this->assertEquals($expected, $gsp->toArray());

        $query = new Filtered(new MatchAll(), $gsp);
        $results = $type->search($query);

        $this->assertEquals(1, $results->count());
    }

    /**
     * @group unit
     */
    public function testConstructPolygon()
    {
        $polygon = array(array(102.0, 2.0), array(103.0, 2.0), array(103.0, 3.0), array(103.0, 3.0), array(102.0, 2.0));
        $gsp = new GeoShapeProvided('location', $polygon, GeoShapeProvided::TYPE_POLYGON);

        $expected = array(
            'geo_shape' => array(
                'location' => array(
                    'shape' => array(
                        'type' => GeoShapeProvided::TYPE_POLYGON,
                        'coordinates' => $polygon,
                    ),
                    'relation' => $gsp->getRelation(),
                ),
            ),
        );

        $this->assertEquals($expected, $gsp->toArray());
    }

    /**
     * @group unit
     */
    public function testSetRelation()
    {
        $gsp = new GeoShapeProvided('location', array(array(25.0, 75.0), array(75.0, 25.0)));
        $gsp->setRelation(AbstractGeoShape::RELATION_INTERSECT);
        $this->assertEquals(AbstractGeoShape::RELATION_INTERSECT, $gsp->getRelation());
        $this->assertInstanceOf('Bonami\Elastica\Filter\GeoShapeProvided', $gsp->setRelation(AbstractGeoShape::RELATION_INTERSECT));
    }
}
