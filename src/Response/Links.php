<?php

namespace Nwiry\BompixSDK\Response;

final class Links
{
    /**
     * @var \Nwiry\BompixSDK\Response\Link[]
     */
    public $payload;

    public function __construct($response)
    {
        if (is_null($response)) {
            $this->payload = [];
            return;
        };

        foreach ($response["payload"] as $link)
            $this->payload[] = new Link(["payload" => $link]);
    }
}
