<?php

namespace Nwiry\BompixSDK\Response;

final class Webhooks
{
    /**
     * @var \Nwiry\BompixSDK\Response\Webhook[]
     */
    public $payload;

    public function __construct($response)
    {   
        if(is_null($response)) {
            $this->payload = [];
            return;
        };

        foreach ($response["payload"] as $link)
            $this->payload[] = new Webhook(["payload" => $link]);
    }
}
