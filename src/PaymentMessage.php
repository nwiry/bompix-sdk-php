<?php

namespace Nwiry\BompixSDK;

use JsonSerializable;

/**
 * PaymentMessage representa os dados do pagador associados a um pagamento.
 */
class PaymentMessage implements JsonSerializable
{
    /**
     * @var string $name O nome do pagador associado ao pagamento.
     */
    public string $name;

    /**
     * @var string $text O texto da mensagem associada ao pagamento.
     */
    public string $text;

    /**
     * @var string $email O endereço de e-mail do pagador associado ao pagamento.
     */
    public string $email;

    /**
     * __construct
     *
     * @param string|null $name O nome do pagador associado ao pagamento.
     * @param string $text O texto da mensagem associada ao pagamento.
     * @param string $email O endereço de e-mail do pagador associado ao pagamento.
     */
    public function __construct(?string $name = "", string $text = "", string $email = "")
    {
        $this->name  = $name ?: "";
        $this->text  = $text ?: "";
        $this->email = $email ?: "";
    }

    /**
     * Método que serializa o objeto para JSON.
     *
     * @return array Os atributos do objeto.
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    /**
     * setName Define o nome do pagador associado ao pagamento.
     *
     * @param string $name O nome do pagador associado ao pagamento.
     * @return \Nwiry\BompixSDK\PaymentMessage
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * getName Obtém o nome do pagador associado ao pagamento.
     *
     * @return string O nome do pagador associado ao pagamento.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * setText Define o texto da mensagem.
     *
     * @param string $text O texto da mensagem associada ao pagamento.
     * @return \Nwiry\BompixSDK\PaymentMessage
     */
    public function setText(string $text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * getText Obtém o texto da mensagem associada ao pagamento.
     *
     * @return string O texto da mensagem associada ao pagamento.
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * setEmail Define o endereço de e-mail do pagador associado ao pagamento.
     *
     * @param string $email O endereço de e-mail do pagador associado ao pagamento.
     * @return \Nwiry\BompixSDK\PaymentMessage
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * getEmail Obtém o endereço de e-mail do pagador associado ao pagamento.
     *
     * @return string O endereço de e-mail do pagador associado ao pagamento.
     */
    public function getEmail()
    {
        return $this->email;
    }
}
