<?php

namespace Nwiry\BompixSDK\Response;

/**
 * Link representa o dado de um link
 */
final class Link
{
    /**
     * @var int $id ID do link.
     */
    public int $id;

    /**
     * @var string $slug Nome do link.
     */
    public string $slug;

    /**
     * @var string $url URL do link
     */
    public string $url;


    /**
     * __construct
     *
     * @param  mixed $response Retorno da API com os dados de informação do link.
     */
    public function __construct($response)
    {
        // Se a resposta for nula, retorna imediatamente
        if (is_null($response)) return;

        // Preenche os atributos com os dados da resposta
        $this->id   = $response["payload"]["id"];
        $this->slug = $response["payload"]["slug"];
        $this->url  = $response["payload"]["url"];
    }
}
