<?php

namespace Nwiry\BompixSDK\Response;

/**
 * Links representa uma coleção de links.
 */
final class Links
{
    /**
     * @var \Nwiry\BompixSDK\Response\Link[] Array de Links
     */
    public $payload;

    /**
     * __construct
     *
     * @param  mixed $response Coleção de link recebida via resposta de API
     */
    public function __construct($response)
    {
        // Inicializa o array de links caso a resposta seja nula
        if (is_null($response)) {
            $this->payload = [];
            return;
        };

        // Preenche o array de links com os dados da resposta
        foreach ($response["payload"] as $link) $this->payload[] = new Link(["payload" => $link]);
    }
}
