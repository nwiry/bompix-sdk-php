# BomPix PHP SDK - v1.1.0

PHP SDK para utilização dos métodos da API Rest BomPix de forma prática e fácil.

## Dependências

- PHP 8+
- Guzzle 7.8+

### Instalação

Execute o comando abaixo no terminal da sua aplicação para instalar a última versão da SDK
```go
composer install nwiry/bompix-sdk-php
```
Ou caso prefira, execute o download da SDK e importe os arquivos com as classes necessárias para as rotas que você deseja interagir.
### Uso da SDK

###### Autenticação:
---
```php
use Nwiry\BompixSDK\Request\AuthRequest;

// Inicialize a autenticação em uma variável
$auth = new AuthRequest("{SUA_CHAVE_DE_API}", "{SUA_CHAVE_SECRETA}");

// Execute a autenticação e salve a resposta da API
$responseAuth = ($auth->login()->getResponse());

// Ex de retorno:
$responseAuth->token; // Bearer Token
// Tempo em segundos para expiração do seu token 
// (Você pode salvar esse tempo em um banco de dados para evitar varias requisições de autenticação)
$responseAuth->expires_in;
// [...]
```

###### Criando links de pagamento:
----
```php
use Nwiry\BompixSDK\Link;
use Nwiry\BompixSDK\Request\LinkRequest;

// Inicialize a instância de link passando o nome do seu link
$link   = new Link("nomedomeulink");

// Obtenha o resultado passando sua resposta de autenticação e o seu link
// Chame a função de criar e obtenha a resposta
$result = (new LinkRequest($responseAuth, $link))->create()->getResponse();

// Ex de retorno:
$result->id; // Id do link gerado
$result->slug; // Nome do link gerado
// [...]
```

###### Obtendo links:
----
```php
use Nwiry\BompixSDK\Link;
use Nwiry\BompixSDK\Request\LinkRequest;

// Obtendo um link especifico via ID:
$link = new Link("nomedomeulink");
$link = (new LinkRequest($responseAuth, $link))->get(1);

// Obtendo um link especifico via Nome:
$link = (new LinkRequest($responseAuth, $link))->get(slug: $link->slug);

// Ex de retorno:
$link->id; // Id do link gerado
$link->slug; // Nome do link gerado
$link->url; // Nome do link gerado

// Obtendo uma lista de links:
$links = (new LinkRequest($responseAuth, $link))->get();
foreach ($links as $key => $link) {
    $link->id; // Id do link
    $link->slug; // Nome do link
    $link->url; // Url do link
}
```

###### Gerando Pagamentos:
----
```php
use Nwiry\BompixSDK\Link;
use Nwiry\BompixSDK\Payment;
use Nwiry\BompixSDK\PaymentMessage;
use Nwiry\BompixSDK\Request\LinkRequest;
use Nwiry\BompixSDK\Request\PaymentRequest;

// Caso não tenha o id do seu link salvo, obtenha-o via API.
$link = new Link("nomedomeulink");
$link = (new LinkRequest($responseAuth, $link))->get(slug: $link->slug);

// Defina os dados do pagamento
$data = new Payment(5.35, $link->id);

// Dados do pagador opcionais:
$payer = new PaymentMessage("João", "Pagamento da fatura #1", "joao@example.com");
$data->setMessage($payer);

// Dados do pagamento gerado:
$payment = (new PaymentRequest($responseAuth, $data))->create()->getResponse();

$payment->uuid;
$payment->qrcode;
$payment->qrcode_png;
$payment->pix_duration;
// [...]
```

###### Obtendo pagamentos:
----
```php
use Nwiry\BompixSDK\Request\PaymentRequest;

// Obtendo um pagamento especifico:
$payment = (new PaymentRequest($responseAuth))->get("{UUID}");

// Obtendo uma lista de pagamentos:
$payments = (new PaymentRequest($responseAuth))->get();

foreach ($payments as $key => $payment) {
    $payment->uuid;
    $payment->qrcode;
    $payment->qrcode_png;
    $payment->pix_duration;
    $payment->paid;
    // [...]
}
```

###### Criando e manuseando Webhooks:
----
```php
use Nwiry\BompixSDK\Link;
use Nwiry\BompixSDK\Request\LinkRequest;
use Nwiry\BompixSDK\Request\WebhookRequest;
use Nwiry\BompixSDK\Webhook;

// Criando um novo webhook para receber notificações:

// Caso não tenha o id do seu link salvo, obtenha-o via API.
$link = (new LinkRequest($responseAuth, (new Link("nomedomeulink"))))->get(slug: $link->slug);

$data = new Webhook($link->id, "{SUA_URL_PARA_NOTIFICAÇÃO}");
$webhook = (new WebhookRequest($responseAuth, $data))->create()->getResponse();

$webhook->id; // Salve o Id do webhook para consultas futuras
// [...]

// Obtendo um webhook especifico:
$webhook = (new WebhookRequest($responseAuth, $data))->get($webhook->id);

$webhook->url; // Url de notificações cadastrada
$webhook->link_id; // Link relacionado ao webhook
// [...]

// Obtendo uma lista de webhooks:
$webhook = (new WebhookRequest($responseAuth, $data))->get();

// Deletando um webhook:
$webhook = (new WebhookRequest($responseAuth, $data))->delete($webhook->id);
```

###### Processando notificações de pagamento (Webhooks)
----
```php
// Inicialize a instância de notificação na rota do seu webhook
$notification = new Notification();

// Processe os dados da notificação de pagamento recebida
$event = $notification->processNotification();

// Como medida de segurança adicional, utilize a API para verificar a veracidade da notificação:
$payment = (new PaymentRequest($responseAuth))->get($event->uuid);
$payment->paid ? "Pagamento efetuado com sucesso" : "O pagamento ainda não foi efetuado";
```

#### Tratando Execeções

> Durante o uso dos métodos para interação com as rotas da API, você pode se deparar com erros durante o caminho, por isso, é importante que você importe também a classe de exceção da biblioteca, para tratar esses possíveis erros, e, manter o bom funcionamento da sua aplicação
----
###### Exemplo de tratamento de exceção:
---
```php
try {
    // Tentativa para gerar o pagamento
    $payment = (new PaymentRequest($responseAuth, $data))->create()->getResponse();
    
    // Ocorreu tudo bem, prossiga com o funcionamento da sua aplicação
} catch (\Nwiry\BompixSDK\Exception\BomPixException $e) {
    // De acordo com as regras da sua aplicação, utilize a mensagem da exceção para prosseguir com as regras do seu funcionamento
}
```