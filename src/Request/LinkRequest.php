<?php

namespace Nwiry\BompixSDK\Request;

use Nwiry\BompixSDK\Link;
use Nwiry\BompixSDK\Response\Auth;
use Nwiry\BompixSDK\Response\Link as ResponseLink;
use Nwiry\BompixSDK\Response\Links as ResponseLinks;

/**
 * LinkRequest oferece métodos para interação com a rota de links.
 */
class LinkRequest extends RequestBase
{
    private $link;

    /**
     * __construct
     *
     * @param \Nwiry\BompixSDK\Response\Auth $auth contém os dados de autenticação
     * @param \Nwiry\BompixSDK\Link $link contém a classe com os dados para interagir com a rota de link
     */
    public function __construct(Auth $auth, Link $link)
    {
        parent::__construct($auth);
        $this->setRoute("/link");
        $this->link = $link;
    }

    /**
     * setLink define a classe com os dados para interagir com a rota de link
     *
     * @param \Nwiry\BompixSDK\Link $link
     * @return \Nwiry\BompixSDK\Request\LinkRequest
     */
    public function setLink(Link $link): LinkRequest
    {
        $this->link = $link;
        return $this;
    }
    
    /**
     * getLink retorna a classe de link com os dados atribuidos
     *
     * @return \Nwiry\BompixSDK\Link
     */
    public function getLink(): Link
    {
        return $this->link;
    }
    
    /**
     * setResponse salva os dados da última requisição com a rota do(s) link(s) em questão
     *
     * @param  mixed $response
     * @return \Nwiry\BompixSDK\Request\LinkRequest
     */
    public function setResponse($response)
    {
        if (isset($response["payload"]["id"])) $this->response = new ResponseLink($response);
        else $this->response = $response;
        return $this;
    }
    
    /**
     * getResponse retorna os dados salvos da última requisição com a rota do link em questão (se singular,
     * caso contrário, se a rota retornar um array multidimensional de links, o retorno da resposta será
     * na mesma função)
     *
     * @return \Nwiry\BompixSDK\Response\Link
     */
    public function getResponse(): ResponseLink
    {
        return $this->response;
    }
    
    /**
     * create gera um novo link e salva os dados do resultado da requisição
     *
     * @return \Nwiry\BompixSDK\Request\LinkRequest
     */
    public function create()
    {
        $this->executeRequest("POST", $this, $this->link);
        return $this;
    }
    
    /**
     * delete exclui o link a partir do seu ID
     *
     * @param  mixed $id
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
     * get obtem um ou mais links a partir do tipo de dado informado
     *
     * @param  mixed $id
     * @param  mixed $slug
     * @return Nwiry\BompixSDK\Response\Link|Nwiry\BompixSDK\Response\Links
     */
    public function get(?int $id = NULL, ?string $slug = NULL): ResponseLink|ResponseLinks
    {
        $_route = $this->route;

        // Verifica-se se foi passado o id ou o nome do link, para filtrá-lo individualmente
        // Caso contrário, todos os links disponiveis serão exibidos
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
