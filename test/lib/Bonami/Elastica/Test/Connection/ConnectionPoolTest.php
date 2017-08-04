<?php
namespace Bonami\Elastica\Test\Connection;

use Bonami\Elastica\Connection;
use Bonami\Elastica\Connection\ConnectionPool;
use Bonami\Elastica\Connection\Strategy\StrategyFactory;
use Bonami\Elastica\Test\Base as BaseTest;

/**
 * @author chabior
 */
class ConnectionPoolTest extends BaseTest
{
    /**
     * @group unit
     */
    public function testConstruct()
    {
        $pool = $this->createPool();

        $this->assertEquals($this->getConnections(), $pool->getConnections());
    }

    /**
     * @group unit
     */
    public function testSetConnections()
    {
        $pool = $this->createPool();

        $connections = $this->getConnections(5);

        $pool->setConnections($connections);

        $this->assertEquals($connections, $pool->getConnections());

        $this->assertInstanceOf('Bonami\Elastica\Connection\ConnectionPool', $pool->setConnections($connections));
    }

    /**
     * @group unit
     */
    public function testAddConnection()
    {
        $pool = $this->createPool();
        $pool->setConnections(array());

        $connections = $this->getConnections(5);

        foreach ($connections as $connection) {
            $pool->addConnection($connection);
        }

        $this->assertEquals($connections, $pool->getConnections());

        $this->assertInstanceOf('Bonami\Elastica\Connection\ConnectionPool', $pool->addConnection($connections[0]));
    }

    /**
     * @group unit
     */
    public function testHasConnection()
    {
        $pool = $this->createPool();

        $this->assertTrue($pool->hasConnection());
    }

    /**
     * @group unit
     */
    public function testFailHasConnections()
    {
        $pool = $this->createPool();

        $pool->setConnections(array());

        $this->assertFalse($pool->hasConnection());
    }

    /**
     * @group unit
     */
    public function testGetConnection()
    {
        $pool = $this->createPool();

        $this->assertInstanceOf('Bonami\Elastica\Connection', $pool->getConnection());
    }

    protected function getConnections($quantity = 1)
    {
        $params = array();
        $connections = array();

        for ($i = 0; $i < $quantity; ++$i) {
            $connections[] = new Connection($params);
        }

        return $connections;
    }

    protected function createPool()
    {
        $connections = $this->getConnections();
        $strategy = StrategyFactory::create('Simple');

        $pool = new ConnectionPool($connections, $strategy);

        return $pool;
    }
}
