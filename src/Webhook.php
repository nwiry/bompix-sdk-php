<?php

namespace Nwiry\BompixSDK;

use JsonSerializable;

/**
 * Webhook representa os dados de um webhook associados a um link.
 */
class Webhook implements JsonSerializable
{
    /**
     * @var int $link_id O ID do link associado ao webhook.
     */
    public int $link_id;

    /**
     * @var string $url A URL do webhook.
     */
    public string $url;

    /**
     * __construct
     *
     * @param int $link_id O ID do link associado ao webhook
     * @param string $url A URL do webhook
     */
    public function __construct(int $link_id = 0, string $url = "")
    {
        $this->link_id = 0;
        $this->url     = $url;
    }

    /**
     * jsonSerialize serializa o objeto para JSON.
     *
     * @return array Os atributos do objeto.
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * setLinkId Define o ID do link associado ao webhook.
     *
     * @param int $link_id O ID do link associado ao webhook.
     * @return \Nwiry\BompixSDK\Webhook
     */
    public function setLinkId(int $link_id)
    {
        $this->link_id = $link_id;
        return $this;
    }

    /**
     * getLinkId Obtém o ID do link associado ao webhook.
     *
     * @return int O ID do link associado ao webhook.
     */
    public function getLinkId()
    {
        return $this->link_id;
    }

    /**
     * setUrl Define a URL do webhook.
     *
     * @param string $url A URL do webhook.
     * @return \Nwiry\BompixSDK\Webhook
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * getUrl Obtém a URL do webhook.
     *
     * @return string A URL do webhook.
     */
    public function getUrl()
    {
        return $this->url;
    }
}
