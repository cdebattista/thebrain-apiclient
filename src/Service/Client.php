<?php

namespace TheBrain\Service;

Class Client {

    protected $client;

    public function __construct(\TheBrain\ApiClient $client){
        $this->client = $client;
    }

    public function all($query = []){
        $url = "/client";
        $response = $this->client->call("get", $url, $query);
        return $response;
    }

    public function get($client_id){
        $url = "/client/" . $client_id;
        $response = $this->client->call("get", $url);
        return $response;
    }

    public function store($query = []){
        $url = "/client";
        $response = $this->client->call("post", $url, $query);
        return $response;
    }

    public function update($client_id, $query = []){
        $url = "/client/".$client_id;
        $response = $this->client->call("put", $url, $query);
        return $response;
    }

    public function delete($client_id){
        $url = "/client/".$client_id;
        $response = $this->client->call("delete", $url);
        return $response;
    }

}