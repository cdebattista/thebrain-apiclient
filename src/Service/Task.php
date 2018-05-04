<?php

namespace TheBrain\Service;

Class Task {

    protected $client;

    public function __construct(\TheBrain\ApiClient $client){
        $this->client = $client;
    }

    public function all($query = []){
        $url = "/task";
        $response = $this->client->call("get", $url, $query);
        return $response;
    }

    public function get($task_id){
        $url = "/task/" . $task_id;
        $response = $this->client->call("get", $url);
        return $response;
    }

    public function store($query = []){
        $url = "/task";
        $response = $this->client->call("post", $url, $query);
        return $response;
    }

    public function update($task_id, $query = []){
        $url = "/task/".$task_id;
        $response = $this->client->call("put", $url, $query);
        return $response;
    }

    public function delete($task_id){
        $url = "/task/".$task_id;
        $response = $this->client->call("delete", $url);
        return $response;
    }

}