<?php

namespace Nwiry\BompixSDK\Request;

use Nwiry\BompixSDK\Exception\BomPixException;
use Nwiry\BompixSDK\Response\Auth as ResponseAuth;

/**
 * AuthRequest oferece métodos para autenticação na API Bompix.
 */
class AuthRequest extends RequestBase
{
    /**
     * __construct
     *
     * @param string $apiKey A chave de API.
     * @param string $apiSecret A chave secreta de API.
     */
    public function __construct(string $apiKey = "", string $apiSecret = "")
    {
        $this->setRoute("/auth");
        $this->apiKey    = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * setApiKey Define a chave de API.
     *
     * @param string $apiKey A chave de API.
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * getApiKey Retorna a chave de API.
     *
     * @return string A chave de API.
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * setApiSecret Define a chave secreta de API.
     *
     * @param string $apiSecret A chave secreta de API.
     */
    public function setApiSecret(string $apiSecret)
    {
        $this->apiSecret = $apiSecret;
        return $this;
    }

    /**
     * getApiSecret Retorna a chave secreta de API.
     *
     * @return string A chave secreta de API.
     */
    public function getApiSecret(): string
    {
        return $this->apiSecret;
    }

    public function setResponse($response)
    {
        $this->response = new ResponseAuth($response);
        return $this;
    }

    public function getResponse(): ResponseAuth
    {
        return $this->response;
    }

    public function login()
    {
        $this->executeRequest("POST", $this);
        return $this;
    }

    public function logout()
    {
        $_apiKey    = $this->apiKey;
        $_apiSecret = $this->apiSecret;

        $this->apiKey = $this->apiSecret = NULL;
        $this->accessToken = ($this->getResponse())->token;

        try {
            $this->executeRequest("DELETE", $this);
            $this->apiKey      = $_apiKey;
            $this->apiSecret   = $_apiSecret;
            $this->accessToken = NULL;
            $this->setResponse(NULL);
        } catch (\Nwiry\BompixSDK\Exception\BomPixException $e) {
            $this->apiKey      = $_apiKey;
            $this->apiSecret   = $_apiSecret;
            $this->accessToken = NULL;
            throw new BomPixException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }
    }
}
