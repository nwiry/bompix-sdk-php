<?php

namespace Nwiry\BompixSDK;

use JsonSerializable;

class Link implements JsonSerializable
{
    public string $slug;

    public function __construct(?string $slug = NULL)
    {
        if (!$slug) $this->slug = "";
        else $this->slug = $slug;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function setSlug(string $slug)
    {
        $this->slug = $slug;
        return $this;
    }

    public function getSlug()
    {
        return $this->slug;
    }
}
