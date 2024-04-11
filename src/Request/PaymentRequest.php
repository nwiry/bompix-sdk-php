<?php

namespace Nwiry\BompixSDK\Request;

use Nwiry\BompixSDK\Payment;
use Nwiry\BompixSDK\Response\Auth;
use Nwiry\BompixSDK\Response\Payment as ResponsePayment;
use Nwiry\BompixSDK\Response\Payments;

class PaymentRequest extends RequestBase
{
    private $payment;

    public function __construct(Auth $auth, Payment $payment)
    {
        parent::__construct($auth);
        $this->setRoute("/webhook");
        $this->payment = $payment;
    }

    public function setPayment(Payment $payment)
    {
        $this->payment = $payment;
        return $this;
    }

    public function getPayment()
    {
        return $this->payment;
    }

    public function setResponse($response)
    {
        if (isset($response["payload"]["uuid"])) $this->response = new ResponsePayment($response);
        else $this->response = $response;
        return $this;
    }

    public function getResponse(): ResponsePayment
    {
        return $this->response;
    }

    public function create()
    {
        $this->executeRequest("POST", $this, $this->payment);
        return $this;
    }

    public function get(?string $uuid = NULL): ResponsePayment|Payments
    {
        $_route = $this->route;
        $param  = "";
        if ($uuid && !empty($uuid)) $param = "/" . $uuid;
        $this->setRoute($this->route . $param);
        try {
            $this->executeRequest("GET", $this);
            $this->setRoute($_route);
            if ($uuid && !empty($uuid)) return $this->getResponse();
            return new Payments($this->response);
        } catch (\Nwiry\BompixSDK\Exception\BomPixException $th) {
            $this->setRoute($_route);
        }
    }
}
