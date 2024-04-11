<?php

namespace Nwiry\BompixSDK;

use JsonSerializable;

class Webhook implements JsonSerializable
{
    public $link_id;
    public $url;

    public function __construct(int $link_id = 0, string $url = "")
    {
        $this->link_id = 0;
        $this->url     = $url;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
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

    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }
}
