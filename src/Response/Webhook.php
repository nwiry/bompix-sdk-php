<?php

namespace Nwiry\BompixSDK\Response;

final class Webhook
{
    public $id;
    public $link_id;
    public $url;

    public function __construct($response)
    {   
        if(is_null($response)) return;

        $this->id      = $response["payload"]["id"];
        $this->link_id = $response["payload"]["link_id"];
        $this->url     = $response["payload"]["url"];
    }
}