<?php

namespace Nwiry\BompixSDK\Response;

/**
 * Webhooks representa uma coleção de webhooks.
 */
final class Webhooks
{
    /**
     * @var \Nwiry\BompixSDK\Response\Webhook[] Array de webhooks
     */
    public $payload;
    
    /**
     * __construct
     *
     * @param  mixed $response Coleção de webhook recebida via resposta de API
     * @return void
     */
    public function __construct($response)
    {   
        // Inicializa o array de webhooks caso a resposta seja nula
        if(is_null($response)) {
            $this->payload = [];
            return;
        };
        
        // Preenche o array de pagamentos com os dados da resposta
        foreach ($response["payload"] as $link) $this->payload[] = new Webhook(["payload" => $link]);
    }
}
