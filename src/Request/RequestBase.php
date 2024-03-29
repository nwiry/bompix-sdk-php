<?php

namespace Nwiry\BompixSDK\Request;

use GuzzleHttp\Client;
use JsonSerializable;
use Nwiry\BompixSDK\Exception\BomPixException;

/**
 * RequestBase fornece funcionalidades básicas para fazer requisições à API Bompix.
 */
abstract class RequestBase
{
    // URL base da API Bompix
    private const API_ENDPOINT = "https://app.bompix.com.br/api/v1";

    // Rota da requisição
    protected string $route;

    /**
     * setResponse efine a resposta da requisição na classe definida em seus respectivos atributos.
     * @param mixed $response A resposta da requisição.
     * @return void
     */
    abstract public function setResponse($response) : void;

    /**
     * executeRequest Executa uma requisição à API Bompix.
     * @param string $method O método HTTP da requisição (POST, GET, DELETE, etc.).
     * @param RequestBase $authorization O objeto de autorização para a requisição.
     * @param JsonSerializable|null $body O corpo da requisição (opcional).
     * @return void
     * @throws BomPixException Se ocorrer um erro durante a execução da requisição.
     */
    public function executeRequest(string $method = "POST", RequestBase $authorization, ?JsonSerializable $body = NULL)
    {
        $options = [];

        // Configura a autenticação
        if (method_exists($authorization, "getApiKey")) $options["auth"] = [$authorization->getApiKey(), $authorization->getApiSecret()];
        else $options["headers"] = ["Authorization" => sprintf("Bearer %s", $authorization->getAccessToken())];

        // Verifica se o corpo da requisição é fornecido e é uma instância de JsonSerializable contendo campos adicionais
        if ($body instanceof JsonSerializable) $options["body"] = json_encode($body);

        try {
            // Realiza a requisição HTTP
            $response = (new Client)->request($method, self::API_ENDPOINT . $this->route, $options);

            // Verifica o código de status da resposta e atribue a resposta à classe definida
            if (in_array($response->getStatusCode(), [200, 201, 204])) $authorization->setResponse($response->getBody()->getContents());
            
            throw new BomPixException("Erro ao executar a requisição." . $response->getStatusCode());
            
        } catch (\Exception $e) {
            throw new BomPixException("Erro ao executar a requisição: " . $e->getMessage());
        }
    }
}
