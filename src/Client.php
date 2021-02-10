<?php

namespace Vegamail;

use GuzzleHttp\Client as GuzzleClient;
use Vegamail\Http\Response;
use Vegamail\Request\PostSendDefinition;
use Vegamail\Request\RequestDefinitionInterface;

/**
 * Class Client
 *
 * @author Jonathan Martin <jonathan@hadoken.io>
 */
class Client
{
    const ENDPOINT = "https://api.vegamail.io";
    
    private $appId;

    private $appToken;

    protected $httpClient;

    /**
     * Constructor.
     * @param $apiToken
     */
    public function __construct($appId, $appToken)
    {
        $this->appId = $appId;
        $this->appToken = $appToken;
        $this->setApiEndpoint(self::ENDPOINT);
    }

    public function setApiEndpoint($url)
    {
        if (preg_match('/http/', $url)) {
            $this->apiEndpoint = $url;
        } else {
            $this->apiEndpoint = sprintf('https://%s', $url);
        }
    }

    public function getClient()
    {
        if (empty($this->httpClient)) {
            $this->httpClient = new GuzzleClient([
                'base_uri' => $this->apiEndpoint,
                'force_ip_resolve' => 'v4',
                'connect_timeout' => 2,
                'timeout' => 3,
                'headers' => [
                    'Content-Type' => 'application/json'
                ]
            ]);
        }

        return $this->httpClient;
    }

    private function sendRequest(RequestDefinitionInterface $definition)
    {
        $body = $definition->getBody();
        $body['_app_id'] = $this->appId;
        $body['_app_token'] = $this->appToken;
        
        $response = $this->getClient()->request(
            $definition->getMethod(),
            $definition->getUrl(),
            [
                'body' => json_encode($body)
            ]
        );

        return new Response($response->getStatusCode(), $response->getBody()->getContents());
    }

    /**
     * @param array $options
     * @return Response
     */
    public function send(array $options = [])
    {
        return $this->sendRequest(new PostSendDefinition($options));
    }

}
