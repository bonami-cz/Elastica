<?php
namespace Bonami\Elastica\Exception;

use Bonami\Elastica\Request;
use Bonami\Elastica\Response;

/**
 * Response exception.
 *
 * @author Nicolas Ruflin <spam@ruflin.com>
 */
class ResponseException extends \RuntimeException implements ExceptionInterface
{
    /**
     * @var \Bonami\Elastica\Request Request object
     */
    protected $_request = null;

    /**
     * @var \Bonami\Elastica\Response Response object
     */
    protected $_response = null;

    /**
     * Construct Exception.
     *
     * @param \Bonami\Elastica\Request  $request
     * @param \Bonami\Elastica\Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        $this->_request = $request;
        $this->_response = $response;
        parent::__construct($response->getError());
    }

    /**
     * Returns request object.
     *
     * @return \Bonami\Elastica\Request Request object
     */
    public function getRequest()
    {
        return $this->_request;
    }

    /**
     * Returns response object.
     *
     * @return \Bonami\Elastica\Response Response object
     */
    public function getResponse()
    {
        return $this->_response;
    }

    /**
     * Returns elasticsearch exception.
     *
     * @return ElasticsearchException
     */
    public function getElasticsearchException()
    {
        $response = $this->getResponse();
        $transfer = $response->getTransferInfo();
        $code = array_key_exists('http_code', $transfer) ? $transfer['http_code'] : 0;

        return new ElasticsearchException($code, $response->getError());
    }
}
