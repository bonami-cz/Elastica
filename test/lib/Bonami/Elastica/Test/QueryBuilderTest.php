<?php
namespace Bonami\Elastica\Test;

use Bonami\Elastica\Exception\QueryBuilderException;
use Bonami\Elastica\Query;
use Bonami\Elastica\QueryBuilder;
use Bonami\Elastica\Suggest;

class QueryBuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group unit
     */
    public function testCustomDSL()
    {
        $qb = new QueryBuilder();

        // test custom DSL
        $qb->addDSL(new CustomDSL());

        $this->assertTrue($qb->custom()->custom_method(), 'custom DSL execution failed');

        // test custom DSL exception message
        $exceptionMessage = '';
        try {
            $qb->invalid();
        } catch (QueryBuilderException $exception) {
            $exceptionMessage = $exception->getMessage();
        }

        $this->assertEquals('DSL "invalid" not supported', $exceptionMessage);
    }

    /**
     * @group unit
     */
    public function testFacade()
    {
        $qb = new QueryBuilder();

        // test one example QueryBuilder flow for each default DSL type
        $this->assertInstanceOf('Bonami\Elastica\Query\AbstractQuery', $qb->query()->match());
        $this->assertInstanceOf('Bonami\Elastica\Filter\AbstractFilter', $qb->filter()->bool());
        $this->assertInstanceOf('Bonami\Elastica\Aggregation\AbstractAggregation', $qb->aggregation()->avg('name'));
        $this->assertInstanceOf('Bonami\Elastica\Suggest\AbstractSuggest', $qb->suggest()->term('name', 'field'));
    }

    /**
     * @group unit
     */
    public function testFacadeException()
    {
        $qb = new QueryBuilder(new QueryBuilder\Version\Version100());

        // undefined
        $exceptionMessage = '';
        try {
            $qb->query()->invalid();
        } catch (QueryBuilderException $exception) {
            $exceptionMessage = $exception->getMessage();
        }

        $this->assertEquals('undefined query "invalid"', $exceptionMessage);

        // unsupported
        $exceptionMessage = '';
        try {
            $qb->aggregation()->top_hits('top_hits');
        } catch (QueryBuilderException $exception) {
            $exceptionMessage = $exception->getMessage();
        }

        $this->assertEquals('aggregation "top_hits" in Version100 not supported', $exceptionMessage);
    }
}

class CustomDSL implements QueryBuilder\DSL
{
    public function getType()
    {
        return 'custom';
    }

    public function custom_method()
    {
        return true;
    }
}
