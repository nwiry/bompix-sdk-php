<?php

namespace Nwiry\BompixSDK\Response;

final class Payment
{
    public $uuid;
    public $link_id;
    public $amount;

    public $message;
    public $paid;
    public $qrcode;

    public $pix_duration;
    public $qrcode_png;
    public $type;

    public function __construct($response)
    {   
        if(is_null($response)) return;
        
    }
}