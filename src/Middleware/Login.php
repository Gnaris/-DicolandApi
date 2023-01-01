<?php

namespace App\Middleware;

use GuzzleHttp\Psr7\Response;
use App\Exception\KeyExpectedException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class Login{

    public function __invoke(Request $req, RequestHandler $handler) : Response
    {
        try{
            $res = new Response();
            if(count($req->getParsedBody()) != 2) throw new KeyExpectedException();
            if(!array_key_exists("login", $req->getParsedBody()))  throw new KeyExpectedException();
            if(!array_key_exists("password", $req->getParsedBody())) throw new KeyExpectedException();

            $res = $handler->handle($req);
            return $res;
        }
        catch(KeyExpectedException $e)
        {
            $res->getBody()->write(json_encode(["success" => false, "message" => "only [login] and [password] key are expected"]));
            return $res;
        }
    }
}

?>