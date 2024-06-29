<?php

namespace Nwiry\BompixSDK;

use JsonSerializable;

/**
 * Payment representa os dados de um pagamento que será gerado via API
 */
class Payment implements JsonSerializable
{
    /**
     * @var int|float $amount Valor do pagamento.
     */
    public int|float $amount;

    /**
     * @var string $type Tipo do pagamento (por exemplo, "pix").
     */
    private string $type;

    /**
     * @var int $link_id ID do link associado ao pagamento.
     */
    public int $link_id;

    /**
     *
     * @var \Nwiry\BompixSDK\PaymentMessage Mensagem associada ao pagamento com os dados do pagador (Opcional)
     */
    public $message;

    /**
     * __construct
     *
     * @param int|float $amount O valor do pagamento.
     * @param int $link_id O ID do link associado ao pagamento.
     * @param PaymentMessage|null $paymentMessage A mensagem associada ao pagamento (opcional).
     */
    public function __construct(int|float $amount = 0, int $link_id, PaymentMessage $paymentMessage = NULL)
    {
        $this->amount  = $amount;
        $this->type    = "pix";
        $this->link_id = $link_id;
        $this->message = $paymentMessage ?? new PaymentMessage();
    }

    /**
     * jsonSerialize serializa o objeto para JSON.
     *
     * @return array Os atributos do objeto.
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * Define o valor do pagamento.
     *
     * @param int|float $amount O valor do pagamento.
     * @return \Nwiry\BompixSDK\Payment
     */
    public function setAmount(int|float $amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * getAmount Obtém o valor do pagamento.
     *
     * @return int|float O valor do pagamento.
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * getType Obtém o tipo do pagamento.
     *
     * @return string O tipo do pagamento.
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * setLinkId Define o ID do link associado ao pagamento.
     *
     * @param int $link_id O ID do link associado ao pagamento.
     * @return \Nwiry\BompixSDK\Payment
     */
    public function setLinkId(int $link_id)
    {
        $this->link_id = $link_id;
        return $this;
    }

    /**
     * getLinkId Obtém o ID do link associado ao pagamento.
     *
     * @return int O ID do link associado ao pagamento.
     */
    public function getLinkId()
    {
        return $this->link_id;
    }

    /**
     * setMessage Define a mensagem associada ao pagamento.
     *
     * @param PaymentMessage $paymentMessage A mensagem associada ao pagamento.
     * @return \Nwiry\BompixSDK\Payment
     */
    public function setMessage(PaymentMessage $paymentMessage)
    {
        $this->message = $paymentMessage;
        return $this;
    }

    /**
     * getMessage Obtém a mensagem associada ao pagamento.
     *
     * @return \Nwiry\BompixSDK\PaymentMessage A mensagem associada ao pagamento.
     */
    public function getMessage()
    {
        return $this->message;
    }
}
