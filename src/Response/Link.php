<?php

namespace Nwiry\BompixSDK\Response;

final class Link
{
    public $id;
    public $slug;
    public $url;

    public function __construct($response)
    {   
        if(is_null($response)) return;

        $this->id   = $response["payload"]["id"];
        $this->slug = $response["payload"]["slug"];
        $this->url  = $response["payload"]["url"];
    }
}