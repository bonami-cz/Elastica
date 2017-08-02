<?php
namespace Bonami\Elastica\Test\QueryBuilder\DSL;

use Bonami\Elastica\Filter\Exists;
use Bonami\Elastica\Query\Match;
use Bonami\Elastica\QueryBuilder\DSL;

class FilterTest extends AbstractDSLTest
{
    /**
     * @group unit
     */
    public function testType()
    {
        $filterDSL = new DSL\Filter();

        $this->assertInstanceOf('Bonami\Elastica\QueryBuilder\DSL', $filterDSL);
        $this->assertEquals(DSL::TYPE_FILTER, $filterDSL->getType());
    }

    /**
     * @group unit
     */
    public function testInterface()
    {
        $filterDSL = new DSL\Filter();

        $this->_assertImplemented($filterDSL, 'bool', 'Bonami\Elastica\Filter\BoolFilter', array());
        $this->_assertImplemented($filterDSL, 'bool_and', 'Bonami\Elastica\Filter\BoolAnd', array(array(new Exists('field'))));
        $this->_assertImplemented($filterDSL, 'bool_not', 'Bonami\Elastica\Filter\BoolNot', array(new Exists('field')));
        $this->_assertImplemented($filterDSL, 'bool_or', 'Bonami\Elastica\Filter\BoolOr', array(array(new Exists('field'))));
        $this->_assertImplemented($filterDSL, 'exists', 'Bonami\Elastica\Filter\Exists', array('field'));
        $this->_assertImplemented($filterDSL, 'geo_bounding_box', 'Bonami\Elastica\Filter\GeoBoundingBox', array('field', array(1, 2)));
        $this->_assertImplemented($filterDSL, 'geo_distance', 'Bonami\Elastica\Filter\GeoDistance', array('key', 'location', 'distance'));
        $this->_assertImplemented($filterDSL, 'geo_distance_range', 'Bonami\Elastica\Filter\GeoDistanceRange', array('key', 'location'));
        $this->_assertImplemented($filterDSL, 'geo_polygon', 'Bonami\Elastica\Filter\GeoPolygon', array('key', array()));
        $this->_assertImplemented($filterDSL, 'geo_shape_pre_indexed', 'Bonami\Elastica\Filter\GeoShapePreIndexed', array('path', 'indexedId', 'indexedType', 'indexedIndex', 'indexedPath'));
        $this->_assertImplemented($filterDSL, 'geo_shape_provided', 'Bonami\Elastica\Filter\GeoShapeProvided', array('path', array()));
        $this->_assertImplemented($filterDSL, 'geohash_cell', 'Bonami\Elastica\Filter\GeohashCell', array('field', 'location'));
        $this->_assertImplemented($filterDSL, 'has_child', 'Bonami\Elastica\Filter\HasChild', array(new Match(), 'type'));
        $this->_assertImplemented($filterDSL, 'has_parent', 'Bonami\Elastica\Filter\HasParent', array(new Match(), 'type'));
        $this->_assertImplemented($filterDSL, 'ids', 'Bonami\Elastica\Filter\Ids', array('type', array()));
        $this->_assertImplemented($filterDSL, 'indices', 'Bonami\Elastica\Filter\Indices', array(new Exists('field'), array()));
        $this->_assertImplemented($filterDSL, 'limit', 'Bonami\Elastica\Filter\Limit', array(1));
        $this->_assertImplemented($filterDSL, 'match_all', 'Bonami\Elastica\Filter\MatchAll', array());
        $this->_assertImplemented($filterDSL, 'missing', 'Bonami\Elastica\Filter\Missing', array('field'));
        $this->_assertImplemented($filterDSL, 'nested', 'Bonami\Elastica\Filter\Nested', array());
        $this->_assertImplemented($filterDSL, 'numeric_range', 'Bonami\Elastica\Filter\NumericRange', array());
        $this->_assertImplemented($filterDSL, 'prefix', 'Bonami\Elastica\Filter\Prefix', array('field', 'prefix'));
        $this->_assertImplemented($filterDSL, 'query', 'Bonami\Elastica\Filter\Query', array(new Match()));
        $this->_assertImplemented($filterDSL, 'range', 'Bonami\Elastica\Filter\Range', array('field', array()));
        $this->_assertImplemented($filterDSL, 'regexp', 'Bonami\Elastica\Filter\Regexp', array('field', 'regex'));
        $this->_assertImplemented($filterDSL, 'script', 'Bonami\Elastica\Filter\Script', array('script'));
        $this->_assertImplemented($filterDSL, 'term', 'Bonami\Elastica\Filter\Term', array());
        $this->_assertImplemented($filterDSL, 'terms', 'Bonami\Elastica\Filter\Terms', array('field', array()));
        $this->_assertImplemented($filterDSL, 'type', 'Bonami\Elastica\Filter\Type', array('type'));
    }
}
