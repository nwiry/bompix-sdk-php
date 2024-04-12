<?php

namespace Nwiry\BompixSDK;

use JsonSerializable;

/**
 * Link representa o dado de um link que será criado via API
 */
class Link implements JsonSerializable
{
    /**
     * @var string $slug Nome do link.
     */
    public string $slug;

    /**
     * __construct
     *
     * @param string|null $slug O nome do link (opcional).
     */
    public function __construct(?string $slug = NULL)
    {
        // Se o nome não for fornecido, este será definido como uma string vazia
        if (!$slug) $this->slug = "";
        else $this->slug = $slug;
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
     * setSlug define o nome do link.
     *
     * @param string $slug O nome do link.
     * @return \Nwiry\BompixSDK\Link
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * getSlug Obtém o slug do link.
     *
     * @return string O nome do link.
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
