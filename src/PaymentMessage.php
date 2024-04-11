<?php

namespace Nwiry\BompixSDK;

use JsonSerializable;

class PaymentMessage implements JsonSerializable
{
    public string $name;
    public string $text;
    public string $email;

    /**
     * @var \Nwiry\BompixSDK\PaymentMessage
     */
    public $message;

    public function __construct(?string $name = "", string $text = "", string $email = "")
    {
        $this->name  = $name;
        $this->text  = $text;
        $this->email = $email;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setText(string $text)
    {
        $this->text = $text;
        return $this;
    }

    public function getText()
    {
        return $this->text;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }
}
