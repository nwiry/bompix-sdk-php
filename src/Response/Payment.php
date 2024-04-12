<?php

namespace Nwiry\BompixSDK\Response;

use Nwiry\BompixSDK\PaymentMessage;

/**
 * Payment representa os dados de um pagamento gerado via API
 */
final class Payment
{
    /**
     * @var string UUID do pagamento.
     */
    public string $uuid;

    /**
     * @var int ID do link associado ao pagamento.
     */
    public int $link_id;

    /**
     * @var int|float Valor do pagamento. Pode ser um inteiro ou um float, dependendo da precisão dos valores.
     */
    public int|float $amount;

    /**
     * @var \Nwiry\BompixSDK\PaymentMessage Mensagem com os dados do pagador associado ao pagamento.
     */
    public $message;

    /**
     * @var bool Indica se o pagamento foi efetuado.
     */
    public bool $paid;

    /**
     * @var string|null QR code associado ao pagamento.
     */
    public ?string $qrcode;

    /**
     * @var int|null Duração do PIX em segundos.
     */
    public ?int $pix_duration;

    /**
     * @var string|null URL do QR code em formato PNG.
     */
    public ?string $qrcode_png;

    /**
     * @var string Tipo de pagamento.
     */
    public string $type;

    /**
     * @var string|null Data e hora do pagamento.
     */
    public ?string $date_time;

    /**
     * __construct
     *
     * @param mixed $response Retorno da API com os dados da requisição de pagamento
     */
    public function __construct($response)
    {
        // Se a resposta for nula, retorna imediatamente
        if (is_null($response)) return;

        // Preenche os atributos com os dados da resposta
        $this->uuid         = $response["payload"]["uuid"];
        $this->link_id      = $response["payload"]["link_id"] ?? $response["payload"]["links_id"];
        $this->amount       = $response["payload"]["amount"];
        $this->message      = new PaymentMessage(
            $response["payload"]["name"] ?? "",
            $response["payload"]["text"] ?? "",
            $response["payload"]["email"] ?? ""
        );
        $this->paid         = $response["payload"]["paid"];
        $this->date_time    = $response["payload"]["date_time"] ?? NULL;
        $this->qrcode       = $response["payload"]["qrcode"]    ?? NULL;
        $this->qrcode_png   = $response["payload"]["qrcode"]    ?? NULL;
        $this->type         = $response["payload"]["type"]      ?? "pix";
        $this->pix_duration = $response["payload"]["pix_duration"] ?? NULL;
    }
}
