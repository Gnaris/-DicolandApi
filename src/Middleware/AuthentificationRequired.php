<?php

namespace App\Middleware;

use App\Entity\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GuzzleHttp\Psr7\Response;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AuthentificationRequired{

    public function __invoke(Request $req, RequestHandler $handler) : Response
    {
        try{
            if(count($req->getHeader("Authorization")) === 0) throw new \UnexpectedValueException();
            $token = explode(" ", $req->getHeader("Authorization")[0])[1];
            $decode = JWT::decode($token, new Key(\App\Config\Key::$jwt, 'HS256'));
        }catch(ExpiredException | SignatureInvalidException $e)
        {
            $res = new Response();
            $res->getBody()->write(json_encode(["response" => false, "message" => "Veuillez vous reconnecter", "error" => $e->getMessage()]));
            return $res
            ->withStatus(511)
            ->withHeader("Content-Type", "application/json");
        }
        catch(\UnexpectedValueException $e)
        {
            $res = new Response();
            $res->getBody()->write(json_encode(["response" => false, "message" => "Veuillez vous connecter"]));
            return $res
            ->withStatus(511)
            ->withHeader("Content-Type", "application/json");
        }
        $res = $handler->handle($req);
        return $res
        ->withStatus(200)
        ->withHeader("Content-Type", "application/json");
    }
}

?>