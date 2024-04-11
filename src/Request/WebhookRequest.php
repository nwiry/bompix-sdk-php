<?php

namespace Nwiry\BompixSDK\Request;

use Nwiry\BompixSDK\Link;
use Nwiry\BompixSDK\Response\Auth;
use Nwiry\BompixSDK\Response\Links as ResponseLinks;
use Nwiry\BompixSDK\Response\Webhook as ResponseWebhook;
use Nwiry\BompixSDK\Response\Webhooks;
use Nwiry\BompixSDK\Webhook;

class WebhookRequest extends RequestBase
{
    private $webhook;

    public function __construct(Auth $auth, Link $link)
    {
        parent::__construct($auth);
        $this->setRoute("/webhook");
        $this->webhook = $link;
    }

    public function setWebhook(Webhook $link)
    {
        $this->webhook = $link;
        return $this;
    }

    public function getWebhook()
    {
        return $this->webhook;
    }

    public function setResponse($response)
    {
        if (isset($response["payload"]["id"])) $this->response = new ResponseWebhook($response);
        else $this->response = $response;
        return $this;
    }

    public function getResponse(): ResponseWebhook
    {
        return $this->response;
    }

    public function create()
    {
        $this->executeRequest("POST", $this, $this->webhook);
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

    public function get(?int $id = NULL): ResponseWebhook|Webhooks
    {
        $_route = $this->route;
        $param = "";
        if ($id) $param = "/" . $id;
        $this->setRoute($this->route . $param);
        try {
            $this->executeRequest("GET", $this);
            $this->setRoute($_route);
            if ($id) return $this->getResponse();
            return new Webhooks($this->response);
        } catch (\Nwiry\BompixSDK\Exception\BomPixException $th) {
            $this->setRoute($_route);
        }
    }
}
