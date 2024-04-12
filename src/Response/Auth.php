<?php

namespace Nwiry\BompixSDK\Response;

/**
 * Auth representa os atributos retornados no payload de uma requisição bem-sucedida de autenticação.
 */
final class Auth
{
    /**
     * @var string $token Token de autenticação.
     */
    public string $token;

    /**
     * @var string $token_type Tipo do token de autenticação (por exemplo, "Bearer").
     */
    public string $token_type;

    /**
     * @var string $expires_in Tempo de expiração do token de autenticação, em segundos.
     */
    public string $expires_in;

    /**
     * __construct
     *
     * @param  mixed $response Retorno da API com os dados de autenticação
     */
    public function __construct($response)
    {
        // Se a resposta for nula, retorna imediatamente
        if (is_null($response)) return;

        // Preenche os atributos com os dados da resposta
        $this->token      = $response["payload"]["token"];
        $this->token_type = $response["payload"]["token_type"];
        $this->expires_in = $response["payload"]["expires_in"];
    }
}
