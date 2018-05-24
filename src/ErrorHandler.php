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

    public function getFile(){
        if($this->error() && isset($this->api->getResponse()->data->file)){
            return $this->api->getResponse()->data->file;
        }
        return null;
    }

    public function getLine(){
        if($this->error() && isset($this->api->getResponse()->data->line)){
            return $this->api->getResponse()->data->line;
        }
        return null;
    }

    public function getClientIp(){
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
    }

    public function getClientName(){
        return isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : null;
    }

    public function getClientScript(){
        return isset($_SERVER['SCRIPT_FILENAME']) ? $_SERVER['SCRIPT_FILENAME'] : null;
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
                    'file'              => $this->getFile(),
                    'line'              => $this->getLine(),
                    'status_code'       => $this->getStatusCode(),
                    'client_ip'         => $this->getClientIp(),
                    'client_name'       => $this->getClientName(),
                    'client_script'     => $this->getClientScript(),
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
                    'file'          => $e->getFile(),
                    'line'          => $e->getLine(),
                    'status_code'   => 500
                ]
            ];
            $response = json_encode($response, JSON_FORCE_OBJECT|JSON_PRETTY_PRINT);
            $response = json_decode($response, false);
        }
        return $response;
    }
}