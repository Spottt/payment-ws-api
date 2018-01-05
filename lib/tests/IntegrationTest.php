<?php


use LemonWay\LemonWayAPI;
use Lyranetwork\PaymentRequest;
use Lyranetwork\WsApi;

require_once('vendor/autoload.php');
require_once('init.php');


class IntegrationTest extends \PHPUnit_Framework_TestCase
{


    // require_once('/home/phi/Dev/myb/mybrocante/vendor/lyranetwork/payment-ws-api/init.php');
    //apt-get install php7.0-soap


    public function create_cancel()
    {


//        $this->cancel_transaction($uuid);
        //$this->get_details($uuid);
        $wsApi = $this->create_ws();
        $paymentUUID = $this->create_test_payment($wsApi);
        $this->assertNotNull($paymentUUID);
        $cancelResult = $this->cancel_transaction($wsApi, $paymentUUID);
        $this->assertTrue($cancelResult);


    }

    public function test_create_capture_cancel()
    {


        $wsApi = $this->create_ws();
        $paymentUUID = $this->create_test_payment($wsApi);
        $this->assertNotNull($paymentUUID);
        $captureResult = $this->capture_transaction($wsApi, $paymentUUID);
        $this->assertTrue($captureResult);
//        $cancelResult = $this->cancel_transaction($wsApi, $paymentUUID);
//        $this->assertTrue($cancelResult);


    }

    public function findAllWaitingForCaptureTransactionsUUID()
    {
        $queryRequest = new \Lyranetwork\QueryRequest();

        $wsApi = $this->create_ws();

        $findPaymentsDetails = new \Lyranetwork\FindPayments();
        $findPaymentsDetails->setQueryRequest($queryRequest);

        $requestId = $wsApi->setHeaders();

        $findPaymentsResponse = $wsApi->findPayments($findPaymentsDetails);
        var_dump($findPaymentsResponse);


    }

    /*
     * Only for tests purposes. Create payment need to have strong PCI authorization cause card number go
     * through your platform
     */
    public function create_test_payment($wsApi)
    {

        try {
            $paymentRequest = new PaymentRequest();
            $paymentRequest->setAmount('1299');
            $paymentRequest->setCurrency('978');

            $cardRequest = new \Lyranetwork\CardRequest();
            $cardRequest->setNumber('4970100000780000');
            $cardRequest->setExpiryMonth('06');
            $cardRequest->setExpiryYear('2020');
            $cardRequest->setCardSecurityCode('123');
            $cardRequest->setScheme('VISA');


            $transactionId = str_pad((string)rand(1, 899999), 6, "0", STR_PAD_LEFT);
            var_dump($transactionId);
            $orderRequest = new \Lyranetwork\OrderRequest();
            $orderRequest->setOrderId($transactionId);

            $payment = new \Lyranetwork\CreatePayment();
            $payment->setPaymentRequest($paymentRequest);
            $payment->setCardRequest($cardRequest);
            $payment->setOrderRequest($orderRequest);
            $wsApi->setHeaders();

            $getPaymentDetailsResponse = $wsApi->createPayment($payment);

            $wsApi->checkAuthenticity();
            return $getPaymentDetailsResponse->getCreatePaymentResult()->getPaymentResponse()->getTransactionUuid();
        } catch (Exception $e) {
            echo '<pre>';
            echo "\n ### ERROR - Something's wrong, an exception raised during process:\n";
            echo $e;
            echo '</pre>';
            return null;
        }
    }

    public function cancel_transaction(WsApi $wsApi, $uuid)
    {
        try {

            $queryRequest = new \Lyranetwork\QueryRequest();
            $queryRequest->setUuid($uuid); // a known transaction UUID
            $commonRequest = new \Lyranetwork\CommonRequest();

            $cancelPaymentDetails = new \Lyranetwork\CancelPayment();
            $cancelPaymentDetails->setQueryRequest($queryRequest);
            $cancelPaymentDetails->setCommonRequest($commonRequest);

            $requestId = $wsApi->setHeaders();

            $createPaymentDetailsResponse = $wsApi->cancelPayment($cancelPaymentDetails);

            var_dump($cancelPaymentDetails);

            $wsApi->checkAuthenticity();
            return true;
        } catch (\Exception $e) {
            var_dump("Exception with code {$e->getCode()}: {$e->getMessage()}");
            return false;
            // friendly message here
        }
    }


    public function capture_transaction(WsApi $wsApi, $uuid)
    {
        try {


            $wsApi->setHeaders();


            $settlementRequest = new \Lyranetwork\SettlementRequest();
            $settlementRequest->setTransactionUuids([$uuid]);
            $settlementRequest->setDate(new \DateTime("+ 100 seconds"));
            $settlementRequest->setCommission(0.0);
            $capturePayment = new \Lyranetwork\CapturePayment($settlementRequest);
            $capturePayment->setSettlementRequest($settlementRequest);
            $createPaymentDetailsResponse = $wsApi->capturePayment($capturePayment);
            var_dump($createPaymentDetailsResponse);


            $wsApi->checkAuthenticity();

            return true;
        } catch (\Exception $e) {
            var_dump("Exception with code {$e->getCode()}: {$e->getMessage()}");
            return false;
            // friendly message here
        }
    }

    public function get_details($uuid)
    {


        $wsApi = $this->create_ws();
        try {
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
                    'INITIAL',
                    'WAITING_AUTHORISATION',
                    'WAITING_AUTHORISATION_TO_VALIDATE',
                    'UNDER_VERIFICATION',
                    'AUTHORISED',
                    'AUTHORISED_TO_VALIDATE',
                    'CAPTURED',
                    'CAPTURE_FAILED'
                ) // pending or accepted payment
            );
//            var_dump("OK");
//            var_dump($getPaymentDetailsResponse->getGetPaymentDetailsResult()->getCommonResponse());
        } catch (\SoapFault $f) {
            //     var_dump("[$requestId] SoapFault with code {$f->faultcode}: {$f->faultstring}.");

            // friendly message here
        } catch (\UnexpectedValueException $e) {
//            var_dump("[$requestId] getPaymentDetails error with code {$e->getCode()}: {$e->getMessage()}.");

            if ($e->getCode() === -1) {
                // manage authentication error here
            } elseif ($e->getCode() === 1) {
                // merchant does not subscribe to WS option
            } else {
                // manage other unexpected response here
            }
        } catch (\Exception $e) {
            var_dump("[$requestId] Exception with code {$e->getCode()}: {$e->getMessage()}");

            // friendly message here
        }

    }

    public function create_ws()
    {

        $configwsfilepath = "config-ws.ini";
        try {
            $configws = parse_ini_file($configwsfilepath);
        } catch (\Exception $e) {
            $this->fail("Unable to open or parse config file in $configwsfilepath");
        }

        $mode = $configws['mode'];
        $keyTest = $configws['keyTest'];
        $keyProd = $configws['keyProd'];
        $shopId = $configws['shopId'];

        // proxy options if any
        $options = array();

        $wsApi = new WsApi($options);

        $wsApi->init($shopId, $mode, $keyTest, $keyProd);

        return $wsApi;
    }

}