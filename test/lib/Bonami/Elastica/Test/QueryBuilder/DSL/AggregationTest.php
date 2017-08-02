<?php
namespace Bonami\Elastica\Test\QueryBuilder\DSL;

use Bonami\Elastica\Filter\Exists;
use Bonami\Elastica\QueryBuilder\DSL;

class AggregationTest extends AbstractDSLTest
{
    /**
     * @group unit
     */
    public function testType()
    {
        $aggregationDSL = new DSL\Aggregation();

        $this->assertInstanceOf('Bonami\Elastica\QueryBuilder\DSL', $aggregationDSL);
        $this->assertEquals(DSL::TYPE_AGGREGATION, $aggregationDSL->getType());
    }

    /**
     * @group unit
     */
    public function testInterface()
    {
        $aggregationDSL = new DSL\Aggregation();

        $this->_assertImplemented($aggregationDSL, 'avg', 'Bonami\Elastica\Aggregation\Avg', array('name'));
        $this->_assertImplemented($aggregationDSL, 'cardinality', 'Bonami\Elastica\Aggregation\Cardinality', array('name'));
        $this->_assertImplemented($aggregationDSL, 'date_histogram', 'Bonami\Elastica\Aggregation\DateHistogram', array('name', 'field', 1));
        $this->_assertImplemented($aggregationDSL, 'date_range', 'Bonami\Elastica\Aggregation\DateRange', array('name'));
        $this->_assertImplemented($aggregationDSL, 'extended_stats', 'Bonami\Elastica\Aggregation\ExtendedStats', array('name'));
        $this->_assertImplemented($aggregationDSL, 'filter', 'Bonami\Elastica\Aggregation\Filter', array('name', new Exists('field')));
        $this->_assertImplemented($aggregationDSL, 'filters', 'Bonami\Elastica\Aggregation\Filters', array('name'));
        $this->_assertImplemented($aggregationDSL, 'geo_distance', 'Bonami\Elastica\Aggregation\GeoDistance', array('name', 'field', 'origin'));
        $this->_assertImplemented($aggregationDSL, 'geohash_grid', 'Bonami\Elastica\Aggregation\GeohashGrid', array('name', 'field'));
        $this->_assertImplemented($aggregationDSL, 'global_agg', 'Bonami\Elastica\Aggregation\GlobalAggregation', array('name'));
        $this->_assertImplemented($aggregationDSL, 'histogram', 'Bonami\Elastica\Aggregation\Histogram', array('name', 'field', 1));
        $this->_assertImplemented($aggregationDSL, 'ipv4_range', 'Bonami\Elastica\Aggregation\IpRange', array('name', 'field'));
        $this->_assertImplemented($aggregationDSL, 'max', 'Bonami\Elastica\Aggregation\Max', array('name'));
        $this->_assertImplemented($aggregationDSL, 'min', 'Bonami\Elastica\Aggregation\Min', array('name'));
        $this->_assertImplemented($aggregationDSL, 'missing', 'Bonami\Elastica\Aggregation\Missing', array('name', 'field'));
        $this->_assertImplemented($aggregationDSL, 'nested', 'Bonami\Elastica\Aggregation\Nested', array('name', 'path'));
        $this->_assertImplemented($aggregationDSL, 'percentiles', 'Bonami\Elastica\Aggregation\Percentiles', array('name'));
        $this->_assertImplemented($aggregationDSL, 'range', 'Bonami\Elastica\Aggregation\Range', array('name'));
        $this->_assertImplemented($aggregationDSL, 'reverse_nested', 'Bonami\Elastica\Aggregation\ReverseNested', array('name'));
        $this->_assertImplemented($aggregationDSL, 'scripted_metric', 'Bonami\Elastica\Aggregation\ScriptedMetric', array('name'));
        $this->_assertImplemented($aggregationDSL, 'significant_terms', 'Bonami\Elastica\Aggregation\SignificantTerms', array('name'));
        $this->_assertImplemented($aggregationDSL, 'stats', 'Bonami\Elastica\Aggregation\Stats', array('name'));
        $this->_assertImplemented($aggregationDSL, 'sum', 'Bonami\Elastica\Aggregation\Sum', array('name'));
        $this->_assertImplemented($aggregationDSL, 'terms', 'Bonami\Elastica\Aggregation\Terms', array('name'));
        $this->_assertImplemented($aggregationDSL, 'top_hits', 'Bonami\Elastica\Aggregation\TopHits', array('name'));
        $this->_assertImplemented($aggregationDSL, 'value_count', 'Bonami\Elastica\Aggregation\ValueCount', array('name', 'field'));

        $this->_assertNotImplemented($aggregationDSL, 'children', array('name'));
        $this->_assertNotImplemented($aggregationDSL, 'geo_bounds', array('name'));
        $this->_assertNotImplemented($aggregationDSL, 'percentile_ranks', array('name'));
    }
}
