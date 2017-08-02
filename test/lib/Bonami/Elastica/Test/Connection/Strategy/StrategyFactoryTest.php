<?php
namespace Bonami\Elastica\Test\Connection\Strategy;

use Bonami\Elastica\Connection\Strategy\StrategyFactory;
use Bonami\Elastica\Test\Base;

/**
 * Description of StrategyFactoryTest.
 *
 * @author chabior
 */
class StrategyFactoryTest extends Base
{
    /**
     * @group unit
     */
    public function testCreateCallbackStrategy()
    {
        $callback = function ($connections) {
        };

        $strategy = StrategyFactory::create($callback);

        $this->assertInstanceOf('Bonami\Elastica\Connection\Strategy\CallbackStrategy', $strategy);
    }

    /**
     * @group unit
     */
    public function testCreateByName()
    {
        $strategyName = 'Simple';

        $strategy = StrategyFactory::create($strategyName);

        $this->assertInstanceOf('Bonami\Elastica\Connection\Strategy\Simple', $strategy);
    }

    /**
     * @group unit
     */
    public function testCreateByClass()
    {
        $strategy = new EmptyStrategy();

        $this->assertEquals($strategy, StrategyFactory::create($strategy));
    }

    /**
     * @group unit
     */
    public function testCreateByClassName()
    {
        $strategyName = '\Bonami\Elastica\Test\Connection\Strategy\EmptyStrategy';

        $strategy = StrategyFactory::create($strategyName);

        $this->assertInstanceOf($strategyName, $strategy);
    }

    /**
     * @group unit
     * @expectedException \InvalidArgumentException
     */
    public function testFailCreate()
    {
        $strategy = new \stdClass();

        StrategyFactory::create($strategy);
    }

    /**
     * @group unit
     */
    public function testNoCollisionWithGlobalNamespace()
    {
        // create collision
        if (!class_exists('Simple')) {
            class_alias('Bonami\Elastica\Util', 'Simple');
        }
        $strategy = StrategyFactory::create('Simple');
        $this->assertInstanceOf('Bonami\Elastica\Connection\Strategy\Simple', $strategy);
    }
}
