<?php

namespace TheBrain\Service;

Class Report {

    protected $client;

    public function __construct(\TheBrain\ApiClient $client){
        $this->client = $client;
    }

    public function all($client_id, $query = []){
        $url = "/client/" . $client_id . "/report";
        $response = $this->client->call("get", $url, $query);
        return $response;
    }

    public function get($client_id, $report_id){
        $url = "/client/" . $client_id . "/report/" . $report_id;
        $response = $this->client->call("get", $url);
        return $response;
    }

    public function store($client_id, $query = []){
        $url = "/client/" . $client_id . "/report";
        $response = $this->client->call("post", $url, $query);
        return $response;
    }

    public function update($client_id, $report_id, $query = []){
        $url = "/client/" . $client_id . "/report/" . $report_id;
        $response = $this->client->call("put", $url, $query);
        return $response;
    }

    public function delete($client_id, $report_id){
        $url = "/client/" . $client_id . "/report/" . $report_id;
        $response = $this->client->call("delete", $url);
        return $response;
    }

}