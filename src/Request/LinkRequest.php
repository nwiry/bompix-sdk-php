<?php

namespace Nwiry\BompixSDK\Request;

use Nwiry\BompixSDK\Link;
use Nwiry\BompixSDK\Response\Auth;
use Nwiry\BompixSDK\Response\Link as ResponseLink;
use Nwiry\BompixSDK\Response\Links as ResponseLinks;

class LinkRequest extends RequestBase
{
    private $link;

    public function __construct(Auth $auth, Link $link)
    {
        parent::__construct($auth);
        $this->setRoute("/link");
        $this->link = $link;
    }

    public function setLink(Link $link)
    {
        $this->link = $link;
        return $this;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setResponse($response)
    {
        if (isset($response["payload"]["id"])) $this->response = new ResponseLink($response);
        else $this->response = $response;
        return $this;
    }

    public function getResponse(): ResponseLink
    {
        return $this->response;
    }

    public function create()
    {
        $this->executeRequest("POST", $this, $this->link);
        return $this;
    }

    public function delete(int $id)
    {
        $_route = $this->route;
        $this->setRoute($this->route . "/" . $id);
        try {
            $this->executeRequest("DELETE", $this);
            $this->setRoute($_route);
        } catch (\Nwiry\BompixSDK\Exception\BomPixException $th) {
            $this->setRoute($_route);
        }
    }

    public function get(?int $id = NULL, ?string $slug = NULL): ResponseLink|ResponseLinks
    {
        $_route = $this->route;
        if ($id || $slug && !empty($slug)) {
            if ($id) $param = "/" . $id;
            else if ($slug && !empty($slug)) $param = "/slug/" . $slug;
            else $param = "";
            $this->setRoute($this->route . $param);
        }
        try {
            $this->executeRequest("GET", $this);
            $this->setRoute($_route);
            if ($id || $slug && !empty($slug)) return $this->getResponse();
            return new ResponseLinks($this->response);
        } catch (\Nwiry\BompixSDK\Exception\BomPixException $th) {
            $this->setRoute($_route);
        }
    }
}
