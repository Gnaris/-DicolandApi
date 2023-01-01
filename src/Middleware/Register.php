<?php

namespace App\Middleware;

use App\Model\UserModel;
use GuzzleHttp\Psr7\Response;
use App\Exception\InvalidMailException;
use App\Exception\KeyExpectedException;

use App\Exception\AccountExistException;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class Register extends Middleware{

    public function __invoke(Request $req, RequestHandler $handler) : Response
    {
        $model = new UserModel();
        $columns_name = $model->getColumnsName();
        try{
            if(count(array_diff_key($columns_name, $req->getParsedBody())) > 0) throw new KeyExpectedException();
            if(\filter_var($req->getParsedBody()["email"], FILTER_VALIDATE_EMAIL) === false) throw new InvalidMailException();
            if($model->isExistingAccount($req->getParsedBody()["email"])) throw new AccountExistException();

            return $handler->handle($req);
        }catch(KeyExpectedException $e)
        {
            $keys = "";
            foreach(array_keys(array_diff_key($columns_name, $req->getParsedBody())) as $value) $keys .= '[' . $value . '] and ';
            $keys = preg_replace('/\W\w+\s*(\W*)$/', '$1', $keys);
            return $this->sendResponse(false, $keys . ' are expected', 404, "Key expected");
        }catch(AccountExistException $e)
        {
            return $this->sendResponse(false, "this account is already exist", 404, "Existing Account");
        }catch(InvalidMailException $e)
        {
            return $this->sendResponse(false, "invalid mail", 404, 'Invalid Mail');
        }
    }
}

?>