<?php

namespace Nwiry\BompixSDK\Response;

final class Payments
{
    /**
     * @var \Nwiry\BompixSDK\Response\Payment[]
     */
    public $payload;

    public function __construct($response)
    {   
        if(is_null($response)) {
            $this->payload = [];
            return;
        };

        foreach ($response["payload"] as $link)
            $this->payload[] = new Payment(["payload" => $link]);
    }
}
