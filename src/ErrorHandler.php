<?php

namespace TheBrain;

Class ErrorHandler {

    protected $api;

    public function __construct($api)
    {
        $this->api = $api;
    }

    public function error(){
        if(isset($this->api->getResponse()->data->status_code)){
            return true;
        }
        return false;
    }

    public function getStatusCode(){
        if($this->error()){
            return $this->api->getResponse()->data->status_code;
        }
        return false;
    }

    public function getMessage(){
        if($this->error()){
            return $this->api->getResponse()->data->message;
        }
        return false;
    }

    public function debug(){
        if($this->error()){
            $response = [
                'data' => [
                    'url'               => $this->api->getUrl(),
                    'method'            => $this->api->getMethod(),
                    'query'             => $this->api->getQuery(),
                    'header'            => $this->api->getHeader(),
                    'message'           => $this->getMessage(),
                    'status_code'       => $this->getStatusCode()
                ]
            ];
            $response = json_encode($response, JSON_FORCE_OBJECT|JSON_PRETTY_PRINT);
            $response = json_decode($response, false);
            return $response;
        }
        return false;
    }

    public function statusCodeHandling($e){
        if($e->getResponse()) {
            $response = json_decode($e->getResponse()->getBody(true)->getContents());
        }else{
            //HERE API_URL CANNOT BE REACH
            $response = [
                'data' => [
                    'message'       => $e->getMessage(),
                    'status_code'   => 500
                ]
            ];
            $response = json_encode($response, JSON_FORCE_OBJECT|JSON_PRETTY_PRINT);
            $response = json_decode($response, false);
        }
        return $response;
    }
}