<?php

namespace Nwiry\BompixSDK;

use Nwiry\BompixSDK\Request\RequestBase;

/**
 * Auth oferece métodos para autenticação na API Bompix.
 */
class Auth extends RequestBase
{
    private string $apiKey;
    private string $apiSecret;

    /**
     * __construct
     *
     * @param string $apiKey A chave de API.
     * @param string $apiSecret A chave secreta de API.
     */
    public function __construct(string $apiKey = "", string $apiSecret = "")
    {
        $this->apiKey    = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * setApiKey Define a chave de API.
     *
     * @param string $apiKey A chave de API.
     * @return void
     */
    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
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
     * @return void
     */
    public function setApiSecret(string $apiSecret): void
    {
        $this->apiSecret = $apiSecret;
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
}
