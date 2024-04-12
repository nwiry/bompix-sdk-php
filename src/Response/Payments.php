<?php

namespace Nwiry\BompixSDK\Response;

/**
 * Payments representa uma coleção de pagamentos.
 */
final class Payments
{
    /**
     * @var \Nwiry\BompixSDK\Response\Payment[] Array de pagamentos
     */
    public $payload;

    /**
     * __construct
     *
     * @param  mixed $response Coleção de pagamento recebida via resposta de API
     */
    public function __construct($response)
    {
        // Inicializa o array de pagamentos caso a resposta seja nula
        if (is_null($response)) {
            $this->payload = [];
            return;
        };

        // Preenche o array de pagamentos com os dados da resposta
        foreach ($response["payload"] as $link) $this->payload[] = new Payment(["payload" => $link]);
    }
}
