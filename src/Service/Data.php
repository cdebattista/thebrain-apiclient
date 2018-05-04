<?php

namespace TheBrain\Service;

Class Data {

    protected $client;

    public function __construct(\TheBrain\ApiClient $client){
        $this->client = $client;
    }

    public function all($client_id, $query = []){
        $url = "/client/" . $client_id . "/data";
        $response = $this->client->call("get", $url, $query);
        return $response;
    }

    public function get($client_id, $data_id){
        $url = "/client/" . $client_id . "/data/" . $data_id;
        $response = $this->client->call("get", $url);
        return $response;
    }

    public function store($client_id, $query = []){
        $url = "/client/" . $client_id . "/data";
        $response = $this->client->call("post", $url, $query);
        return $response;
    }

    public function update($client_id, $data_id, $query = []){
        $url = "/client/" . $client_id . "/data/" . $data_id;
        $response = $this->client->call("put", $url, $query);
        return $response;
    }

    public function delete($client_id, $data_id){
        $url = "/client/" . $client_id . "/data/" . $data_id;
        $response = $this->client->call("delete", $url);
        return $response;
    }

}