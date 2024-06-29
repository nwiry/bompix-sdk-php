<?php

namespace Nwiry\BompixSDK;

use Nwiry\BompixSDK\Exception\BomPixException;
use Nwiry\BompixSDK\Response\NotificationWebhook;

/**
 * Notification é responsável por gerenciar notificações de pagamentos recebidas do serviço Bompix.
 */
class Notification
{
    /**
     * Versão da API Bompix para notificações.
     */
    public const BOMPIX_API_V0 = "v0";
    public const BOMPIX_API_V1 = "v1";

    /**
     * @var string $version A versão da API Bompix para notificações.
     */
    private $version;

    /**
     * Construtor da classe Notification.
     *
     * @param string $version A versão da API Bompix para notificações (padrão: v1).
     * @throws BomPixException Se a versão da API não for suportada.
     */
    public function __construct(string $version = Notification::BOMPIX_API_V1)
    {
        $this->validVersion($version);
        $this->version = $version;
    }

    /**
     * validVersion Valida se a versão da API é suportada.
     *
     * @param string $version A versão da API Bompix para notificações.
     * @throws BomPixException Se a versão da API não for suportada.
     */
    public function validVersion(string $version)
    {
        if (!in_array($version, [
            Notification::BOMPIX_API_V0,
            Notification::BOMPIX_API_V1
        ])) throw new BomPixException("Versão de API não suportada");
    }

    /**
     * Define a versão da API Bompix para notificações.
     *
     * @param string $version A versão da API Bompix para notificações.
     * @return \Nwiry\BompixSDK\Notification
     */
    public function setVersion(string $version)
    {
        $this->validVersion($version);
        $this->version = $version;
        return $this;
    }

    /**
     * getVersion Retorna a versão da API Bompix para notificações.
     *
     * @return string A versão da API Bompix para notificações.
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * processNotification Lê a notificação recebida e retorna um objeto NotificationWebhook correspondente.
     *
     * @return \Nwiry\BompixSDK\Response\NotificationWebhook O objeto NotificationWebhook correspondente à notificação recebida.
     */
    public function processNotification(): NotificationWebhook
    {
        // Lê os dados da notificação do corpo da requisição
        $request = json_decode(file_get_contents('php://input'), true);
        // Se o corpo da requisição estiver vazio, tenta obter dados da superglobal $_REQUEST
        if (!$request) $request = $_REQUEST;

        // Instancia o objeto NotificationWebhook de acordo com a versão da API
        switch ($this->version) {
            case Notification::BOMPIX_API_V0:
                $notification = new NotificationWebhook(["payment" => $request]);
                break;
            default:
                $notification = new NotificationWebhook($request);
                break;
        }

        return $notification;
    }
}
