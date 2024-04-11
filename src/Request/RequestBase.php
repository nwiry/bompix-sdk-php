<?php

namespace Nwiry\BompixSDK\Request;

use GuzzleHttp\Client;
use JsonSerializable;
use Nwiry\BompixSDK\Exception\BomPixException;
use Nwiry\BompixSDK\Response\Auth;

/**
 * RequestBase fornece funcionalidades básicas para fazer requisições à API Bompix.
 */
abstract class RequestBase
{
    // URL base da API Bompix
    private const API_ENDPOINT = "https://app.bompix.com.br/api/v1";

    // Rota da requisição
    protected string $route;

    protected $accessToken;
    protected $apiKey;
    protected $apiSecret;

    public $response;

    public function __construct(?Auth $auth = NULL)
    {
        if ($auth) $this->accessToken = $auth->token;
    }

    protected function setRoute(string $route)
    {
        $this->route = $route;
        return $this;
    }

    /**
     * getApiKey retorna a chave de api caso atribuida na classe
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * getApiSecret retorna a chave secreta da api caso atribuida na classe
     *
     * @return string
     */
    public function getApiSecret(): string
    {
        return $this->apiSecret;
    }

    /**
     * getAccessToken retorna o token de acesso gerado na autenticação com a API
     *
     * @return void
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * setResponse define a resposta da requisição na classe definida em seus respectivos atributos.
     * @param mixed $response A resposta da requisição.
     */
    abstract public function setResponse($response);

    /**
     * executeRequest executa uma requisição à API Bompix.
     * @param string $method O método HTTP da requisição (POST, GET, DELETE, etc.).
     * @param RequestBase $authorization O objeto de autorização para a requisição.
     * @param JsonSerializable|null $body O corpo da requisição (opcional).
     * @return void
     * @throws BomPixException Se ocorrer um erro durante a execução da requisição.
     */
    protected function executeRequest(string $method = "POST", RequestBase $authorization, ?JsonSerializable $body = NULL)
    {
        $options = [];

        // Configura a autenticação
        if ($this->apiSecret || $this->apiKey) {
            $options['headers'] = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($authorization->getApiKey() . ':' . $authorization->getApiSecret())
            ];
        } else $options["headers"] = ["Authorization" => sprintf("Bearer %s", $authorization->getAccessToken())];

        // Verifica se o corpo da requisição é fornecido e é uma instância de JsonSerializable contendo campos adicionais
        if ($body instanceof JsonSerializable) $options["body"] = json_encode($body);

        try {
            // Realiza a requisição HTTP
            $response = (new Client)->request($method, self::API_ENDPOINT . $this->route, $options);

            // Verifica o código de status da resposta e atribue a resposta à classe definida
            if (in_array($response->getStatusCode(), [200, 201, 204])) {
                if (!in_array(strtoupper($method), ["GET", "POST"])) return;
                $authorization->setResponse(json_decode($response->getBody()->getContents(), true));
                return;
            }

            throw new BomPixException("Erro ao executar a requisição: " . $response->getStatusCode());
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            var_dump($e->getResponse()->getBody()->getContents());
            throw new BomPixException("Erro ao executar a requisição: " . $e->getMessage());
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            throw new BomPixException("Erro ao executar a requisição: " . $e->getMessage());
        } catch (\Exception $e) {
            throw new BomPixException("Erro ao executar a requisição: " . $e->getMessage());
        }
    }
}
