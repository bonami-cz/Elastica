<?php
namespace Bonami\Elastica\Test\QueryBuilder\DSL;

use Bonami\Elastica\Filter\Exists;
use Bonami\Elastica\Query\Match;
use Bonami\Elastica\QueryBuilder\DSL;

class QueryTest extends AbstractDSLTest
{
    /**
     * @group unit
     */
    public function testType()
    {
        $queryDSL = new DSL\Query();

        $this->assertInstanceOf('Bonami\Elastica\QueryBuilder\DSL', $queryDSL);
        $this->assertEquals(DSL::TYPE_QUERY, $queryDSL->getType());
    }

    /**
     * @group unit
     */
    public function testMatch()
    {
        $queryDSL = new DSL\Query();

        $match = $queryDSL->match('field', 'match');
        $this->assertEquals('match', $match->getParam('field'));
        $this->assertInstanceOf('Bonami\Elastica\Query\Match', $match);
    }

    /**
     * @group unit
     */
    public function testInterface()
    {
        $queryDSL = new DSL\Query();

        $this->_assertImplemented($queryDSL, 'bool', 'Bonami\Elastica\Query\BoolQuery', array());
        $this->_assertImplemented($queryDSL, 'boosting', 'Bonami\Elastica\Query\Boosting', array());
        $this->_assertImplemented($queryDSL, 'common_terms', 'Bonami\Elastica\Query\Common', array('field', 'query', 0.001));
        $this->_assertImplemented($queryDSL, 'constant_score', 'Bonami\Elastica\Query\ConstantScore', array(new Match()));
        $this->_assertImplemented($queryDSL, 'dis_max', 'Bonami\Elastica\Query\DisMax', array());
        $this->_assertImplemented($queryDSL, 'filtered', 'Bonami\Elastica\Query\Filtered', array(new Match(), new Exists('field')));
        $this->_assertImplemented($queryDSL, 'function_score', 'Bonami\Elastica\Query\FunctionScore', array());
        $this->_assertImplemented($queryDSL, 'fuzzy', 'Bonami\Elastica\Query\Fuzzy', array('field', 'type'));
        $this->_assertImplemented($queryDSL, 'fuzzy_like_this', 'Bonami\Elastica\Query\FuzzyLikeThis', array());
        $this->_assertImplemented($queryDSL, 'has_child', 'Bonami\Elastica\Query\HasChild', array(new Match()));
        $this->_assertImplemented($queryDSL, 'has_parent', 'Bonami\Elastica\Query\HasParent', array(new Match(), 'type'));
        $this->_assertImplemented($queryDSL, 'ids', 'Bonami\Elastica\Query\Ids', array('type', array()));
        $this->_assertImplemented($queryDSL, 'match', 'Bonami\Elastica\Query\Match', array('field', 'values'));
        $this->_assertImplemented($queryDSL, 'match_all', 'Bonami\Elastica\Query\MatchAll', array());
        $this->_assertImplemented($queryDSL, 'more_like_this', 'Bonami\Elastica\Query\MoreLikeThis', array());
        $this->_assertImplemented($queryDSL, 'multi_match', 'Bonami\Elastica\Query\MultiMatch', array());
        $this->_assertImplemented($queryDSL, 'nested', 'Bonami\Elastica\Query\Nested', array());
        $this->_assertImplemented($queryDSL, 'prefix', 'Bonami\Elastica\Query\Prefix', array());
        $this->_assertImplemented($queryDSL, 'query_string', 'Bonami\Elastica\Query\QueryString', array());
        $this->_assertImplemented($queryDSL, 'range', 'Bonami\Elastica\Query\Range', array('field', array()));
        $this->_assertImplemented($queryDSL, 'regexp', 'Bonami\Elastica\Query\Regexp', array('field', 'value', 1.0));
        $this->_assertImplemented($queryDSL, 'simple_query_string', 'Bonami\Elastica\Query\SimpleQueryString', array('query'));
        $this->_assertImplemented($queryDSL, 'term', 'Bonami\Elastica\Query\Term', array());
        $this->_assertImplemented($queryDSL, 'terms', 'Bonami\Elastica\Query\Terms', array('field', array()));
        $this->_assertImplemented($queryDSL, 'top_children', 'Bonami\Elastica\Query\TopChildren', array(new Match(), 'type'));
        $this->_assertImplemented($queryDSL, 'wildcard', 'Bonami\Elastica\Query\Wildcard', array());

        $this->_assertNotImplemented($queryDSL, 'custom_boost_factor', array());
        $this->_assertNotImplemented($queryDSL, 'custom_filters_score', array());
        $this->_assertNotImplemented($queryDSL, 'custom_score', array());
        $this->_assertNotImplemented($queryDSL, 'field', array());
        $this->_assertNotImplemented($queryDSL, 'fuzzy_like_this_field', array());
        $this->_assertNotImplemented($queryDSL, 'geo_shape', array());
        $this->_assertNotImplemented($queryDSL, 'indices', array());
        $this->_assertNotImplemented($queryDSL, 'minimum_should_match', array());
        $this->_assertNotImplemented($queryDSL, 'more_like_this_field', array());
        $this->_assertNotImplemented($queryDSL, 'span_first', array());
        $this->_assertNotImplemented($queryDSL, 'span_multi_term', array());
        $this->_assertNotImplemented($queryDSL, 'span_near', array());
        $this->_assertNotImplemented($queryDSL, 'span_not', array());
        $this->_assertNotImplemented($queryDSL, 'span_or', array());
        $this->_assertNotImplemented($queryDSL, 'span_term', array());
        $this->_assertNotImplemented($queryDSL, 'template', array());
        $this->_assertNotImplemented($queryDSL, 'text', array());
    }
}
