<?php

namespace Nwiry\BompixSDK\Response;

use Nwiry\BompixSDK\Exception\BomPixException;
use Nwiry\BompixSDK\PaymentMessage;

/**
 * Payment representa os dados da notificação de um pagamento recebido
 */
final class NotificationWebhook
{
    /**
     * @var string UUID do pagamento.
     */
    public string $uuid;

    /**
     * @var int|null ID do link associado ao pagamento. Pode ser nulo a depender da versão da notificação
     */
    public ?int $links_id;

    /**
     * @var int|float|null Valor do pagamento. Pode ser um inteiro, float ou nulo, dependendo da precisão dos valores e da versão da notificação.
     */
    public int|float|null $amount;

    /**
     * @var \Nwiry\BompixSDK\PaymentMessage|null Mensagem com os dados do pagador associado ao pagamento. Dependendo da versão da notificação, este atributo pode ser nulo.
     */
    public $message;

    /**
     * __construct
     *
     * @param mixed $response Retorno da API com os dados da notificação de pagamento
     * @throws \Nwiry\BompixSDK\Exception\BomPixException Gera uma exceção caso a notificação recebida seja inválida ou vazia
     */
    public function __construct($response)
    {
        // Se a resposta for nula, ou invalida, retorna uma exceção
        if (is_null($response) || is_null($response["payment"]) || !isset($response["payment"]) || !$response || empty($response))
            throw new BomPixException("A notificação recebida é inválida");

        // Preenche os atributos com os dados da resposta
        $this->uuid         = $response["payment"]["uuid"];
        $this->links_id      = $response["payment"]["links_id"] ?? NULL;
        $this->amount       = $response["payment"]["amount"] ?? NULL;
        $this->message      = new PaymentMessage(
            $response["payment"]["name"] ?? "",
            $response["payment"]["text"] ?? "",
            $response["payment"]["email"] ?? ""
        );
    }
}
