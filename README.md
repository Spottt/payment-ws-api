# Lyra payment WS API

Lyra payment WS API is an open source PHP API that allows making SOAP WS calls to secured payment services developped by [Lyra Network](https://www.lyra-network.com/) inside e-commerce websites.

## Requirements

PHP 5.3.0 and later.

## Installation

### Composer 

You can install the API via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require lyranetwork/payment-ws-api
```

To use the API, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

```php
require_once('vendor/autoload.php');
```

### Manual Installation

If you do not wish to use Composer, you can download the [latest release](https://github.com/payzen/payment-ws-api/releases). Then, to use the API, include the `init.php` file.

```php
require_once('/path/to/payment-ws-api/init.php');
```

## Usage

```php
try {
    $ctxMode = 'TEST';
    $keyTest = '1111111111111111';
    $keyProd = '2222222222222222';
    $shopId = '12345678';

    // proxy options if any
    $options = array(
        'proxy_host' => 'host',
        'proxy_port' => '3128',
        'proxy_login' => 'login',
        'proxy_password' => 'password'
    );

    $wsApi = new \Lyranetwork\WsApi($options, $url);
    $wsApi->init($shopId, $ctxMode, $keyTest, $keyProd);

    // example of getPaymentDetails call
    $queryRequest = new \Lyranetwork\QueryRequest();
    $queryRequest->setUuid($uuid); // a known transaction UUID

    $getPaymentDetails = new \Lyranetwork\GetPaymentDetails($queryRequest);
    $getPaymentDetails->setQueryRequest($queryRequest);

    $requestId = $wsApi->setHeaders();

    $getPaymentDetailsResponse = $wsApi->getPaymentDetails($getPaymentDetails);

    $wsApi->checkAuthenticity();
    $wsApi->checkResult(
        $getPaymentDetailsResponse->getGetPaymentDetailsResult()->getCommonResponse(),
        array(
    'INITIAL', 'WAITING_AUTHORISATION', 'WAITING_AUTHORISATION_TO_VALIDATE', 'UNDER_VERIFICATION',
    'AUTHORISED', 'AUTHORISED_TO_VALIDATE', 'CAPTURED', 'CAPTURE_FAILED'
        ) // pending or accepted payment
    );

} catch(\SoapFault $f) {
    log("[$requestId] SoapFault with code {$f->faultcode}: {$f->faultstring}.", Zend_Log::WARN);

    // friendly message here 
} catch(\UnexpectedValueException $e) {
    log("[$requestId] getPaymentDetails error with code {$e->getCode()}: {$e->getMessage()}.", Zend_Log::ERR);

    if ($e->getCode() === -1) {
        // manage authentication error here
    } elseif ($e->getCode() === 1) {
        // merchant does not subscribe to WS option
    } else {
        // manage other unexpected response here
    }
} catch (Exception $e) {
    log("[$requestId] Exception with code {$e->getCode()}: {$e->getMessage()}", Zend_Log::ERR);

    // friendly message here 
}
```

## License

Each Lyra payment WS API source file included in this distribution is licensed under GNU GENERAL PUBLIC LICENSE (GPL 3.0).

Please see LICENSE.txt for the full text of the GPL 3.0 license. It is also available through the world-wide-web at this URL: http://www.gnu.org/licenses/.
