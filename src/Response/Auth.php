<?php

namespace Nwiry\BompixSDK\Response;

/**
 * Auth retorna os atributos setados no payload do request de uma requisição bem-sucedida
 */
final class Auth
{
    public $token;
    public $tokenType;
    public $expiresIn;

    public function __construct($response)
    {
        if(is_null($response)) return;
        
        $this->token = $response["payload"]["token"];
        $this->tokenType = $response["payload"]["token_type"];
        $this->expiresIn = $response["payload"]["expires_in"];
    }
}