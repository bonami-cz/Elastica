<?php
namespace Bonami\Elastica\Test\Query;

use Bonami\Elastica\Query\Builder;
use Bonami\Elastica\Test\Base as BaseTest;

class BuilderTest extends BaseTest
{
    /**
     * @group unit
     * @covers \Bonami\Elastica\Query\Builder::factory
     * @covers \Bonami\Elastica\Query\Builder::__construct
     */
    public function testFactory()
    {
        $this->assertInstanceOf(
            'Bonami\Elastica\Query\Builder',
            Builder::factory('some string')
        );
    }

    public function getQueryData()
    {
        return array(
            array('allowLeadingWildcard', false, '{"allow_leading_wildcard":"false"}'),
            array('allowLeadingWildcard', true, '{"allow_leading_wildcard":"true"}'),
            array('analyzeWildcard', false, '{"analyze_wildcard":"false"}'),
            array('analyzeWildcard', true, '{"analyze_wildcard":"true"}'),
            array('analyzer', 'someAnalyzer', '{"analyzer":"someAnalyzer"}'),
            array('autoGeneratePhraseQueries', true, '{"auto_generate_phrase_queries":"true"}'),
            array('autoGeneratePhraseQueries', false, '{"auto_generate_phrase_queries":"false"}'),
            array('boost', 2, '{"boost":"2"}'),
            array('boost', 4.2, '{"boost":"4.2"}'),
            array('defaultField', 'fieldName', '{"default_field":"fieldName"}'),
            array('defaultOperator', 'OR', '{"default_operator":"OR"}'),
            array('defaultOperator', 'AND', '{"default_operator":"AND"}'),
            array('enablePositionIncrements', true, '{"enable_position_increments":"true"}'),
            array('enablePositionIncrements', false, '{"enable_position_increments":"false"}'),
            array('explain', true, '{"explain":"true"}'),
            array('explain', false, '{"explain":"false"}'),
            array('from', 42, '{"from":"42"}'),
            array('fuzzyMinSim', 4.2, '{"fuzzy_min_sim":"4.2"}'),
            array('fuzzyPrefixLength', 2, '{"fuzzy_prefix_length":"2"}'),
            array('gt', 10, '{"gt":"10"}'),
            array('gte', 11, '{"gte":"11"}'),
            array('lowercaseExpandedTerms', true, '{"lowercase_expanded_terms":"true"}'),
            array('lt', 10, '{"lt":"10"}'),
            array('lte', 11, '{"lte":"11"}'),
            array('minimumNumberShouldMatch', 21, '{"minimum_number_should_match":"21"}'),
            array('phraseSlop', 6, '{"phrase_slop":"6"}'),
            array('size', 7, '{"size":"7"}'),
            array('tieBreakerMultiplier', 7, '{"tie_breaker_multiplier":"7"}'),
            array('matchAll', 1.1, '{"match_all":{"boost":"1.1"}}'),
            array('fields', array('age', 'sex', 'location'), '{"fields":["age","sex","location"]}'),
        );
    }

    /**
     * @group unit
     * @dataProvider getQueryData
     * @covers \Bonami\Elastica\Query\Builder::__toString
     * @covers \Bonami\Elastica\Query\Builder::allowLeadingWildcard
     * @covers \Bonami\Elastica\Query\Builder::analyzeWildcard
     * @covers \Bonami\Elastica\Query\Builder::analyzer
     * @covers \Bonami\Elastica\Query\Builder::autoGeneratePhraseQueries
     * @covers \Bonami\Elastica\Query\Builder::boost
     * @covers \Bonami\Elastica\Query\Builder::defaultField
     * @covers \Bonami\Elastica\Query\Builder::defaultOperator
     * @covers \Bonami\Elastica\Query\Builder::enablePositionIncrements
     * @covers \Bonami\Elastica\Query\Builder::explain
     * @covers \Bonami\Elastica\Query\Builder::from
     * @covers \Bonami\Elastica\Query\Builder::fuzzyMinSim
     * @covers \Bonami\Elastica\Query\Builder::fuzzyPrefixLength
     * @covers \Bonami\Elastica\Query\Builder::gt
     * @covers \Bonami\Elastica\Query\Builder::gte
     * @covers \Bonami\Elastica\Query\Builder::lowercaseExpandedTerms
     * @covers \Bonami\Elastica\Query\Builder::lt
     * @covers \Bonami\Elastica\Query\Builder::lte
     * @covers \Bonami\Elastica\Query\Builder::minimumNumberShouldMatch
     * @covers \Bonami\Elastica\Query\Builder::phraseSlop
     * @covers \Bonami\Elastica\Query\Builder::size
     * @covers \Bonami\Elastica\Query\Builder::tieBreakerMultiplier
     * @covers \Bonami\Elastica\Query\Builder::matchAll
     * @covers \Bonami\Elastica\Query\Builder::fields
     */
    public function testAllowLeadingWildcard($method, $argument, $result)
    {
        $builder = new Builder();
        $this->assertSame($builder, $builder->$method($argument));
        $this->assertSame($result, (string) $builder);
    }

    public function getQueryTypes()
    {
        return array(
            array('bool', 'bool'),
            array('constantScore', 'constant_score'),
            array('disMax', 'dis_max'),
            array('facets', 'facets'),
            array('filter', 'filter'),
            array('filteredQuery', 'filtered'),
            array('must', 'must'),
            array('mustNot', 'must_not'),
            array('prefix', 'prefix'),
            array('query', 'query'),
            array('queryString', 'query_string'),
            array('range', 'range'),
            array('should', 'should'),
            array('sort', 'sort'),
            array('term', 'term'),
            array('textPhrase', 'text_phrase'),
            array('wildcard', 'wildcard'),
        );
    }

    /**
     * @group unit
     * @dataProvider getQueryTypes
     * @covers \Bonami\Elastica\Query\Builder::fieldClose
     * @covers \Bonami\Elastica\Query\Builder::close
     * @covers \Bonami\Elastica\Query\Builder::bool
     * @covers \Bonami\Elastica\Query\Builder::boolClose
     * @covers \Bonami\Elastica\Query\Builder::constantScore
     * @covers \Bonami\Elastica\Query\Builder::constantScoreClose
     * @covers \Bonami\Elastica\Query\Builder::disMax
     * @covers \Bonami\Elastica\Query\Builder::disMaxClose
     * @covers \Bonami\Elastica\Query\Builder::facets
     * @covers \Bonami\Elastica\Query\Builder::facetsClose
     * @covers \Bonami\Elastica\Query\Builder::filter
     * @covers \Bonami\Elastica\Query\Builder::filterClose
     * @covers \Bonami\Elastica\Query\Builder::filteredQuery
     * @covers \Bonami\Elastica\Query\Builder::filteredQueryClose
     * @covers \Bonami\Elastica\Query\Builder::must
     * @covers \Bonami\Elastica\Query\Builder::mustClose
     * @covers \Bonami\Elastica\Query\Builder::mustNot
     * @covers \Bonami\Elastica\Query\Builder::mustNotClose
     * @covers \Bonami\Elastica\Query\Builder::prefix
     * @covers \Bonami\Elastica\Query\Builder::prefixClose
     * @covers \Bonami\Elastica\Query\Builder::query
     * @covers \Bonami\Elastica\Query\Builder::queryClose
     * @covers \Bonami\Elastica\Query\Builder::queryString
     * @covers \Bonami\Elastica\Query\Builder::queryStringClose
     * @covers \Bonami\Elastica\Query\Builder::range
     * @covers \Bonami\Elastica\Query\Builder::rangeClose
     * @covers \Bonami\Elastica\Query\Builder::should
     * @covers \Bonami\Elastica\Query\Builder::shouldClose
     * @covers \Bonami\Elastica\Query\Builder::sort
     * @covers \Bonami\Elastica\Query\Builder::sortClose
     * @covers \Bonami\Elastica\Query\Builder::term
     * @covers \Bonami\Elastica\Query\Builder::termClose
     * @covers \Bonami\Elastica\Query\Builder::textPhrase
     * @covers \Bonami\Elastica\Query\Builder::textPhraseClose
     * @covers \Bonami\Elastica\Query\Builder::wildcard
     * @covers \Bonami\Elastica\Query\Builder::wildcardClose
     */
    public function testQueryTypes($method, $queryType)
    {
        $builder = new Builder();
        $this->assertSame($builder, $builder->$method()); // open
        $this->assertSame($builder, $builder->{$method.'Close'}()); // close
        $this->assertSame('{"'.$queryType.'":{}}', (string) $builder);
    }

    /**
     * @group unit
     * @covers \Bonami\Elastica\Query\Builder::fieldOpen
     * @covers \Bonami\Elastica\Query\Builder::fieldClose
     * @covers \Bonami\Elastica\Query\Builder::open
     * @covers \Bonami\Elastica\Query\Builder::close
     */
    public function testFieldOpenAndClose()
    {
        $builder = new Builder();
        $this->assertSame($builder, $builder->fieldOpen('someField'));
        $this->assertSame($builder, $builder->fieldClose());
        $this->assertSame('{"someField":{}}', (string) $builder);
    }

    /**
     * @group unit
     * @covers \Bonami\Elastica\Query\Builder::sortField
     */
    public function testSortField()
    {
        $builder = new Builder();
        $this->assertSame($builder, $builder->sortField('name', true));
        $this->assertSame('{"sort":{"name":{"reverse":"true"}}}', (string) $builder);
    }

    /**
     * @group unit
     * @covers \Bonami\Elastica\Query\Builder::sortFields
     */
    public function testSortFields()
    {
        $builder = new Builder();
        $this->assertSame($builder, $builder->sortFields(array('field1' => 'asc', 'field2' => 'desc', 'field3' => 'asc')));
        $this->assertSame('{"sort":[{"field1":"asc"},{"field2":"desc"},{"field3":"asc"}]}', (string) $builder);
    }

    /**
     * @group unit
     * @covers \Bonami\Elastica\Query\Builder::queries
     */
    public function testQueries()
    {
        $queries = array();

        $builder = new Builder();
        $b1 = clone $builder;
        $b2 = clone $builder;

        $queries[] = $b1->term()->field('age', 34)->termClose();
        $queries[] = $b2->term()->field('name', 'christer')->termClose();

        $this->assertSame($builder, $builder->queries($queries));
        $this->assertSame('{"queries":[{"term":{"age":"34"}},{"term":{"name":"christer"}}]}', (string) $builder);
    }

    public function getFieldData()
    {
        return array(
            array('name', 'value', '{"name":"value"}'),
            array('name', true, '{"name":"true"}'),
            array('name', false, '{"name":"false"}'),
            array('name', array(1, 2, 3), '{"name":["1","2","3"]}'),
            array('name', array('foo', 'bar', 'baz'), '{"name":["foo","bar","baz"]}'),
        );
    }

    /**
     * @group unit
     * @dataProvider getFieldData
     * @covers \Bonami\Elastica\Query\Builder::field
     */
    public function testField($name, $value, $result)
    {
        $builder = new Builder();
        $this->assertSame($builder, $builder->field($name, $value));
        $this->assertSame($result, (string) $builder);
    }

    /**
     * @group unit
     * @expectedException \Bonami\Elastica\Exception\InvalidException
     * @expectedExceptionMessage The produced query is not a valid json string : "{{}"
     * @covers \Bonami\Elastica\Query\Builder::toArray
     */
    public function testToArrayWithInvalidData()
    {
        $builder = new Builder();
        $builder->open('foo');
        $builder->toArray();
    }

    /**
     * @group unit
     * @covers \Bonami\Elastica\Query\Builder::toArray
     */
    public function testToArray()
    {
        $builder = new Builder();
        $builder->query()->term()->field('category.id', array(1, 2, 3))->termClose()->queryClose();
        $expected = array(
            'query' => array(
                'term' => array(
                    'category.id' => array(1, 2, 3),
                ),
            ),
        );
        $this->assertEquals($expected, $builder->toArray());
    }
}
