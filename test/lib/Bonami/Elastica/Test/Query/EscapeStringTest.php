<?php
namespace Bonami\Elastica\Test\Query;

use Bonami\Elastica\Document;
use Bonami\Elastica\Index;
use Bonami\Elastica\Query\QueryString;
use Bonami\Elastica\Test\Base as BaseTest;
use Bonami\Elastica\Type;
use Bonami\Elastica\Util;

class EscapeStringTest extends BaseTest
{
    /**
     * @group functional
     */
    public function testSearch()
    {
        $index = $this->_createIndex();
        $index->getSettings()->setNumberOfReplicas(0);

        $type = new Type($index, 'helloworld');

        $doc = new Document(1, array(
            'email' => 'test@test.com', 'username' => 'test 7/6 123', 'test' => array('2', '3', '5'), )
        );
        $type->addDocument($doc);

        // Refresh index
        $index->refresh();

        $queryString = new QueryString(Util::escapeTerm('test 7/6'));
        $resultSet = $type->search($queryString);

        $this->assertEquals(1, $resultSet->count());
    }
}
