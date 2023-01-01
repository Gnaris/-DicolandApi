<?php

namespace App\Controller;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Model\UserModel;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController{

    private UserModel $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }

    public function getUsers(Request $req, Response $res, array $args) : Response
    {
        $ids = explode("/", $args["id"]);
        $res->getBody()->write(json_encode($this->model->getUsersByID($ids)));
        return $res->withStatus(200);
    }

    public function deleteUsers(Request $req, Response $res, array $args) : Response
    {
        $ids = explode("/", $args["id"]);
        $res->getBody()->write(json_encode(["response" => $this->model->deleteUsersByID($ids)]));
        return $res->withStatus(200, "DELETED");
    }

    public function updateUser(Request $req, Response $res, array $args) : Response
    {
        $res->getBody()->write(json_encode($req->getParsedBody()));
        return $res->withHeader("Content-Type", "application/json");
    }

    public function login(Request $req, Response $res, array $args) : Response
    {
        $login = $req->getParsedBody()["login"];
        $password = $req->getParsedBody()["password"];
        $settings = [
            "iat" => time(),
            "exp" => time() + 10
        ]; 
        $data = array_merge($this->model->loginUser($login, $password), $settings);
        $token = JWT::encode($data, \App\Config\Key::$jwt, "HS256");
        $res->getBody()->write(json_encode(["success" => true, "token" => $token]));
        return $res;
    }

    public function register(Request $req, Response $res, array $args) : Response
    {
        $success = $this->model->registerUser($req->getParsedBody());
        $login = $req->getParsedBody()["login"];
        $password = $req->getParsedBody()["password"];
        $settings = [
            "iat" => time(),
            "exp" => time() + 10
        ]; 
        $data = array_merge($this->model->loginUser($login, $password), $settings);
        $token = JWT::encode($data, \App\Config\Key::$jwt, "HS256");
        $res->getBody()->write(\json_encode(["success" => $success, "token" => $token]));
        return $res->withStatus(201);
    }
}

?>