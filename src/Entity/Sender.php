<?php

namespace App\Entity;

use GuzzleHttp\Psr7\Response;

abstract class Sender{

    protected function sendResponse(bool $success, string $message, int $http_code = 200, string $http_message = '') : Response
    {
        $res = new Response();
        $res->getBody()->write(\json_encode(["success" => $success, "message" => $message]));
        return $res->withStatus($http_code, $http_message)->withHeader("Content-Type", "application/json");
    }
}