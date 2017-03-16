<?php

namespace SendBird;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class SendBird
{
    /**
     * @var string
     */
    private $apiToken;

    /**
     * @var SendBird
     */
    private static $instance;

    /**
     * @param array $params
     * @return bool|object
     */
    public function userCreate(array $params)
    {
        $fields = [
            'user_id',
            'nickname',
            'profile_url',
            'issue_access_token',
        ];

        $this->checkParams($params, $fields);

        $url = 'users';
        $result = $this->post($url, $params);

        return $result ?: false;
    }

    private function post($url, array $params)
    {
        return $this->doRequest('post', $url, $params);
    }

    private function missField(array $keys, array $fields)
    {
        $result = array_diff($fields, $keys);
        if (empty($result)) {
            return false;
        }

        return 'missing keys: ' . implode(',', $result);
    }

    private function checkParams(array $params, array $fields)
    {
        if ($this->isAssoc($params)) {
            $keys = array_keys($params);

            $result = $this->invalidField($keys, $fields);
            if ($result !== false) {
                throw new Exception($result);
            }

            $result = $this->missField($keys, $fields);
            if ($result !== false) {
                throw new Exception($result);
            }

            return true;
        }

        throw new Exception('params must a assoc array');
    }

    private function isAssoc(array $arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    private function invalidField(array $keys, array $fields)
    {
        $result = array_diff($keys, $fields);
        if (empty($result)) {
            return false;
        }

        return 'invalid keys: ' . implode(',', $result);
    }

    private function doRequest($method, $url, array $params = [])
    {
        $headers = [
            'Content-Type' => 'application/json, charset=utf8',
            'Api-Token'    => $this->apiToken,
        ];
        $client = new Client([
            'base_uri' => 'https://api.sendbird.com/v3/',
            'timeout'  => 30.0,
        ]);
        $options = [
            'headers' => $headers,
            'verify'  => __DIR__ . '/cacert.pem',
        ];

        if (!empty($params)) {
            $options['json'] = $params;
        }

        try {
            $response = $client->request($method, $url, $options);

            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody());
            }

        } catch (RequestException $e) {
            echo 'request ' . Psr7\str($e->getRequest());
            echo "\r\n";
            echo 'message ' . $e->getMessage();
            echo "\r\n";
            if ($e->hasResponse()) {
                echo 'status ' . $e->getResponse()->getStatusCode();
                echo "\r\n";
                echo 'response ' . $e->getResponse()->getBody();
                echo "\r\n";
            }
        }

        return false;
    }


    public static function getInstance($apiToken)
    {
        if (empty(static::$instance)) {
            static::$instance = new static($apiToken);
        }

        return static::$instance;
    }

    private function __construct($apiToken)
    {
        if (!is_string($apiToken)) {
            throw new Exception('Invalid API token');
        }

        $this->apiToken = $apiToken;
    }

    private function __clone()
    {
        throw new Exception('Not allow clone');
    }
}