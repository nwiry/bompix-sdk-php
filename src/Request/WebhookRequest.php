<?php

namespace Nwiry\BompixSDK\Request;

use Nwiry\BompixSDK\Response\Auth;
use Nwiry\BompixSDK\Response\Webhook as ResponseWebhook;
use Nwiry\BompixSDK\Response\Webhooks;
use Nwiry\BompixSDK\Webhook;

/**
 * WebhookRequest oferece métodos para interação com a rota de links.
 */
class WebhookRequest extends RequestBase
{
    /**
     * @var \Nwiry\BompixSDK\Webhook $webhook O webhook associado à requisição.
     */
    private $webhook;
        
    /**
     * __construct
     *
     * @param \Nwiry\BompixSDK\Response\Auth $auth O objeto de autenticação.
     * @param \Nwiry\BompixSDK\Webhook $webhook O webhook associado à requisição.
     */
    public function __construct(Auth $auth, Webhook $webhook)
    {
        parent::__construct($auth);
        $this->setRoute("/webhook");
        $this->webhook = $webhook;
    }

    /**
     * setWebhook Define o webhook associado à requisição.
     *
     * @param Webhook $webhook O webhook associado à requisição.
     * @return \Nwiry\BompixSDK\Request\WebhookRequest
     */
    public function setWebhook(Webhook $webhook)
    {
        $this->webhook = $webhook;
        return $this;
    }

    /**
     * getWebhook Obtém o webhook associado à requisição.
     *
     * @return Webhook O webhook associado à requisição.
     */
    public function getWebhook()
    {
        return $this->webhook;
    }

    /**
     * setResponse Define a resposta da requisição.
     *
     * @param mixed $response A resposta da requisição.
     * @return \Nwiry\BompixSDK\Request\WebhookRequest
     */
    public function setResponse($response)
    {
        if (isset($response["payload"]["id"])) $this->response = new ResponseWebhook($response);
        else $this->response = $response;
        return $this;
    }

    /**
     * getResponse Obtém a resposta da requisição.
     *
     * @return \Nwiry\BompixSDK\Response\Webhook A resposta da requisição.
     */
    public function getResponse(): ResponseWebhook
    {
        return $this->response;
    }

    /**
     * create Cria um novo webhook.
     *
     * @return \Nwiry\BompixSDK\Request\WebhookRequest
     */
    public function create()
    {
        $this->executeRequest("POST", $this, $this->webhook);
        return $this;
    }

    /**
     * delete Deleta um webhook pelo seu ID.
     *
     * @param int $id O ID do webhook a ser deletado.
     * @return void
     */
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

    /**
     * get Obtém um webhook pelo seu ID.
     *
     * @param int|null $id O ID do webhook a ser obtido.
     * @return \Nwiry\BompixSDK\Response\Webhook|\Nwiry\BompixSDK\Response\Webhooks A resposta da requisição.
     */
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
