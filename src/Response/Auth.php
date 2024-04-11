<?php

namespace Nwiry\BompixSDK\Response;

/**
 * Auth retorna os atributos setados no payload do request de uma requisição bem-sucedida
 */
final class Auth
{
    public $token;
    public $token_type;
    public $expires_in;

    public function __construct($response)
    {
        if(is_null($response)) return;

        $this->token      = $response["payload"]["token"];
        $this->token_type = $response["payload"]["token_type"];
        $this->expires_in = $response["payload"]["expires_in"];
    }
}