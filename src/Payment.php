<?php

namespace Nwiry\BompixSDK;

use JsonSerializable;

class Payment implements JsonSerializable
{
    public int|float $amount;
    public string $type;
    public int $link_id;

    /**
     * @var \Nwiry\BompixSDK\PaymentMessage
     */
    public $message;

    public function __construct(int|float $amount = 0, string $type = "", int $link_id, PaymentMessage $paymentMessage = (new PaymentMessage()))
    {
        $this->amount  = $amount;
        $this->type    = $type;
        $this->link_id = $link_id;
        $this->message = $paymentMessage;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function setAmount(int|float $amount)
    {
        $this->amount = $amount;
        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setLinkId(int $link_id)
    {
        $this->link_id = $link_id;
        return $this;
    }

    public function getLinkId()
    {
        return $this->link_id;
    }

    public function setMessage(PaymentMessage $paymentMessage)
    {
        $this->message = $paymentMessage;
        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
