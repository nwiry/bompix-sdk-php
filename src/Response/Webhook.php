<?php

namespace Nwiry\BompixSDK\Response;

/**
 * Webhook representa os dados de um webhook utilizado para notificações de eventos relacionados a pagamentos.
 */
final class Webhook
{
    /**
     * @var int $id ID do webhook.
     */
    public $id;

    /**
     * @var int $link_id ID do link associado ao webhook.
     */
    public $link_id;

    /**
     * @var string $url URL do webhook.
     */
    public $url;
    
    /**
     * __construct
     *
     * @param  mixed $response Retorno da API com os dados de informação do webhook.
     */
    public function __construct($response)
    {        
        // Se a resposta for nula, retorna imediatamente
        if (is_null($response)) return;

        // Preenche os atributos com os dados da resposta
        $this->id      = $response["payload"]["id"];
        $this->link_id = $response["payload"]["link_id"];
        $this->url     = $response["payload"]["url"];
    }
}
