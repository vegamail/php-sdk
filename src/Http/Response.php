<?php

namespace Vegamail\Http;

/**
 * Response
 *
 * @author Jonathan Martin <jonathan@hadoken.io>
 */
class Response
{
    protected $statusCode;

    protected $body;

    /**
     * @param string $statusCode statusCode
     * @param string $body       body
     */
    public function __construct($statusCode, $body)
    {
        $this->statusCode = $statusCode;
        $this->body       = $body;
    }

    /**
     * @return string
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return json_decode($this->body, true);
    }
}
