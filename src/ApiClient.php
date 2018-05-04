<?php
namespace TheBrain;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

Class ApiClient {

    protected $client;
    protected $access_token;
    protected $refresh_token;
    protected $api_url;
    protected $url;
    protected $method;
    protected $query;
    protected $header;
    protected $response;
    protected $error;
    protected $logger;
    protected $path_logs;

    public function __construct($options = []){
        $this->client           = new Client([
            'defaults' => [
                'verify' => false
            ]
        ]);
        $this->error            = new ErrorHandler($this);
        $this->logger           = new Logger($this);

        $this->api_url          = array_key_exists('api_url', $options) ? $options['api_url'] : 'https://app.thebraindata.com/api';
        $this->access_token     = array_key_exists('access_token', $options) ? $options['access_token'] : null;
        $this->refresh_token    = array_key_exists('refresh_token', $options) ? $options['refresh_token'] : null;
        $this->path_logs        = array_key_exists('path_logs', $options) ? $options['path_logs'] : null;
    }

    public function errorHandler(){
        return $this->error;
    }

    public function logger(){
        return $this->logger;
    }

    public function getUrl(){
        return $this->url;
    }

    public function getMethod(){
        return $this->method;
    }

    public function getQuery(){
        return $this->query;
    }

    public function getHeader(){
        return $this->header;
    }

    public function getResponse(){
        return $this->response;
    }

    public function setApiUrl($api_url){
        $this->api_url = $api_url;
    }

    public function setToken($access_token, $refresh_token = null){
        $this->access_token     = $access_token;
        $this->refresh_token    = $refresh_token;
    }

    public function getPathLogs(){
        return $this->path_logs;
    }

    public function setLogsPath($path_logs){
        $this->path_logs = $path_logs;
    }

    public function call($method, $request, $query = []){
        try {
            $this->url      = $this->api_url . $request;
            $this->query    = $query;
            $this->method   = $method;
            $this->header   = [
                'Authorization'     => 'Bearer ' . $this->access_token,
                'Accept'            => 'application/json',
                'Content-Type'      => 'application/json'
            ];
            $this->response = $this->client->createRequest($this->method, $this->url, ['query' => $this->query, 'headers' => $this->header]);
            $this->response = $this->client->send($this->response);
            $this->response = json_decode($this->response->getBody()->getContents());
            return $this->response;
        } catch (RequestException $e){
            $this->response = $this->error->StatusCodeHandling($e);
            $this->logger->RequestException();
            return $this->response;
        }

    }
}