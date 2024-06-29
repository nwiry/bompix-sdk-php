# 🧰 BomPix PHP SDK - v1.1.2

PHP SDK para utilização dos métodos da API Rest BomPix de forma prática e fácil.

## 🛠 Dependências

- PHP 8+
- Guzzle 7.8+

## 🚀 Instalação

Para instalar a última versão da SDK, execute o comando abaixo:
```sh
composer install nwiry/bompix-sdk-php
```

## 🔑 Autenticação
```php
use Nwiry\BompixSDK\Request\AuthRequest;

// Inicialize a autenticação
$auth = new AuthRequest("{SUA_CHAVE_DE_API}", "{SUA_CHAVE_SECRETA}");

// Execute a autenticação e obtenha a resposta da API
$responseAuth = $auth->login()->getResponse();

// Armazene o token e o tempo de expiração
$token = $responseAuth->token;
$expiresIn = $responseAuth->expires_in;
```

## 🔗 Criando Links de Pagamento
```php
use Nwiry\BompixSDK\Link;
use Nwiry\BompixSDK\Request\LinkRequest;

// Inicialize a instância de link
$link = new Link("nomedomeulink");

// Crie o link de pagamento
$linkRequest = new LinkRequest($responseAuth, $link);
$result = $linkRequest->create()->getResponse();

// Armazene os detalhes do link
$linkId = $result->id;
$linkSlug = $result->slug;
```

## 📜 Obtendo Links
```php
use Nwiry\BompixSDK\Link;
use Nwiry\BompixSDK\Request\LinkRequest;

// Obtenha um link específico via ID
$link = new Link("nomedomeulink");
$linkRequest = new LinkRequest($responseAuth, $link);
$linkDetails = $linkRequest->get(1);

// Obtenha os detalhes do link
$linkId = $linkDetails->id;
$linkSlug = $linkDetails->slug;
$linkUrl = $linkDetails->url;

// Obtenha uma lista de links
$links = $linkRequest->getAll();
foreach ($links as $link) {
    echo $link->id;
    echo $link->slug;
    echo $link->url;
}
```

## 💳 Gerando Pagamentos
```php
use Nwiry\BompixSDK\Link;
use Nwiry\BompixSDK\Payment;
use Nwiry\BompixSDK\PaymentMessage;
use Nwiry\BompixSDK\Request\LinkRequest;
use Nwiry\BompixSDK\Request\PaymentRequest;

// Obtenha o link
$link = new Link("nomedomeulink");
$linkRequest = new LinkRequest($responseAuth, $link);
$linkDetails = $linkRequest->get(slug: $link->slug);

// Defina os dados do pagamento
$paymentData = new Payment(5.35, $linkDetails->id);
$payerMessage = new PaymentMessage("João", "Pagamento da fatura #1", "joao@example.com");
$paymentData->setMessage($payerMessage);

// Crie o pagamento
$paymentRequest = new PaymentRequest($responseAuth, $paymentData);
$payment = $paymentRequest->create()->getResponse();

// Armazene os detalhes do pagamento
$paymentUuid = $payment->uuid;
$paymentQrcode = $payment->qrcode;
$paymentQrcodePng = $payment->qrcode_png;
$paymentPixDuration = $payment->pix_duration;
```

## 📄 Obtendo Pagamentos
```php
use Nwiry\BompixSDK\Request\PaymentRequest;

// Obtenha um pagamento específico
$paymentRequest = new PaymentRequest($responseAuth);
$payment = $paymentRequest->get("{UUID}");

// Obtenha uma lista de pagamentos
$payments = $paymentRequest->getAll();
foreach ($payments as $payment) {
    echo $payment->uuid;
    echo $payment->qrcode;
    echo $payment->qrcode_png;
    echo $payment->pix_duration;
    echo $payment->paid ? "Pago" : "Não Pago";
}
```

## 🔔 Webhooks

### Criando e Manuseando Webhooks
```php
use Nwiry\BompixSDK\Webhook;
use Nwiry\BompixSDK\Request\WebhookRequest;

// Crie um novo webhook
$linkDetails = $linkRequest->get(slug: $link->slug);
$webhookData = new Webhook($linkDetails->id, "{SUA_URL_PARA_NOTIFICACAO}");
$webhookRequest = new WebhookRequest($responseAuth, $webhookData);
$webhook = $webhookRequest->create()->getResponse();

// Obtenha um webhook específico
$webhookDetails = $webhookRequest->get($webhook->id);

// Obtenha uma lista de webhooks
$webhooks = $webhookRequest->getAll();

// Delete um webhook
$webhookRequest->delete($webhook->id);
```

### Processando Notificações de Pagamento (Webhooks)
```php
use Nwiry\BompixSDK\Notification;
use Nwiry\BompixSDK\Request\PaymentRequest;

// Inicialize a instância de notificação na rota do seu webhook
$notification = new Notification();
$event = $notification->processNotification();

// Verifique a veracidade da notificação
$payment = (new PaymentRequest($responseAuth))->get($event->uuid);
$isPaid = $payment->paid ? "Pagamento efetuado com sucesso" : "O pagamento ainda não foi efetuado";
```

## 🛠 Tratando Exceções
```php
use Nwiry\BompixSDK\Exception\BomPixException;

try {
    $paymentRequest = new PaymentRequest($responseAuth, $paymentData);
    $payment = $paymentRequest->create()->getResponse();
} catch (BomPixException $e) {
    echo "Erro: " . $e->getMessage();
}
```

## 📚 Documentação Oficial da API

Para mais informações detalhadas sobre todos os endpoints e funcionalidades disponíveis na API BomPix, consulte a [Documentação Oficial da API](https://www.postman.com/angeloghiotto/workspace/bompix/collection/1972712-e8f7332a-c58f-49b0-9270-a820307775e5?action=share&creator=1972712&active-environment=1972712-4274a100-9718-4e99-9c72-37e458e0716f). Lá você encontrará exemplos de uso, descrições detalhadas dos parâmetros e respostas, além de guias para ajudar na integração com a API.