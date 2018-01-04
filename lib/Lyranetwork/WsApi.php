<?php
/**
 * Copyright (C) 2017 Lyra Network.
 * This file is part of Lyra payment WS API.
 *
 * See COPYING.txt for license details.
 *
 * @author    Lyra Network <contact@lyra-network.com>
 * @copyright 2017 Lyra Network
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License (GPL v3)
 */
namespace Lyranetwork;

class WsApi extends \SoapClient
{
    const HEADER_NAMESPACE = 'http://v5.ws.vads.lyra.com/Header/';
    const DATE_FORMAT = 'Y-m-d\TH:i:s\Z';
    const TIMEOUT = 30; // in seconds

    /**
     * @var array $classmap The defined classes
     */
    private static $classmap = array (
        'cancelCapturedPayment' => 'Lyranetwork\\CancelCapturedPayment',
        'commonRequest' => 'Lyranetwork\\CommonRequest',
        'queryRequest' => 'Lyranetwork\\QueryRequest',
        'cancelCapturedPaymentResponse' => 'Lyranetwork\\CancelCapturedPaymentResponse',
        'cancelCapturedPaymentResult' => 'Lyranetwork\\CancelCapturedPaymentResult',
        'commonResponse' => 'Lyranetwork\\CommonResponse',
        'wsResponse' => 'Lyranetwork\\WsResponse',
        'capturePayment' => 'Lyranetwork\\CapturePayment',
        'settlementRequest' => 'Lyranetwork\\SettlementRequest',
        'capturePaymentResponse' => 'Lyranetwork\\CapturePaymentResponse',
        'capturePaymentResult' => 'Lyranetwork\\CapturePaymentResult',
        'createTokenByIban' => 'Lyranetwork\\CreateTokenByIban',
        'ibanRequest' => 'Lyranetwork\\IbanRequest',
        'customerRequest' => 'Lyranetwork\\CustomerRequest',
        'billingDetailsRequest' => 'Lyranetwork\\BillingDetailsRequest',
        'shippingDetailsRequest' => 'Lyranetwork\\ShippingDetailsRequest',
        'extraDetailsRequest' => 'Lyranetwork\\ExtraDetailsRequest',
        'createTokenByIbanResponse' => 'Lyranetwork\\CreateTokenByIbanResponse',
        'createTokenByIbanResult' => 'Lyranetwork\\CreateTokenByIbanResult',
        'paymentResponse' => 'Lyranetwork\\PaymentResponse',
        'orderResponse' => 'Lyranetwork\\OrderResponse',
        'extInfo' => 'Lyranetwork\\ExtInfo',
        'cardResponse' => 'Lyranetwork\\CardResponse',
        'authorizationResponse' => 'Lyranetwork\\AuthorizationResponse',
        'captureResponse' => 'Lyranetwork\\CaptureResponse',
        'customerResponse' => 'Lyranetwork\\CustomerResponse',
        'billingDetailsResponse' => 'Lyranetwork\\BillingDetailsResponse',
        'shippingDetailsResponse' => 'Lyranetwork\\ShippingDetailsResponse',
        'extraDetailsResponse' => 'Lyranetwork\\ExtraDetailsResponse',
        'markResponse' => 'Lyranetwork\\MarkResponse',
        'threeDSResponse' => 'Lyranetwork\\ThreeDSResponse',
        'authenticationRequestData' => 'Lyranetwork\\AuthenticationRequestData',
        'authenticationResultData' => 'Lyranetwork\\AuthenticationResultData',
        'extraResponse' => 'Lyranetwork\\ExtraResponse',
        'subscriptionResponse' => 'Lyranetwork\\SubscriptionResponse',
        'fraudManagementResponse' => 'Lyranetwork\\FraudManagementResponse',
        'riskControl' => 'Lyranetwork\\RiskControl',
        'riskAnalysis' => 'Lyranetwork\\RiskAnalysis',
        'riskAssessments' => 'Lyranetwork\\RiskAssessments',
        'shoppingCartResponse' => 'Lyranetwork\\ShoppingCartResponse',
        'cartItemInfo' => 'Lyranetwork\\CartItemInfo',
        'reactivateToken' => 'Lyranetwork\\ReactivateToken',
        'reactivateTokenResponse' => 'Lyranetwork\\ReactivateTokenResponse',
        'reactivateTokenResult' => 'Lyranetwork\\ReactivateTokenResult',
        'duplicatePayment' => 'Lyranetwork\\DuplicatePayment',
        'paymentRequest' => 'Lyranetwork\\PaymentRequest',
        'orderRequest' => 'Lyranetwork\\OrderRequest',
        'duplicatePaymentResponse' => 'Lyranetwork\\DuplicatePaymentResponse',
        'duplicatePaymentResult' => 'Lyranetwork\\DuplicatePaymentResult',
        'cancelPayment' => 'Lyranetwork\\CancelPayment',
        'cancelPaymentResponse' => 'Lyranetwork\\CancelPaymentResponse',
        'cancelPaymentResult' => 'Lyranetwork\\CancelPaymentResult',
        'checkThreeDSAuthentication' => 'Lyranetwork\\CheckThreeDSAuthentication',
        'threeDSRequest' => 'Lyranetwork\\ThreeDSRequest',
        'mpiExtensionRequest' => 'Lyranetwork\\MpiExtensionRequest',
        'checkThreeDSAuthenticationResponse' => 'Lyranetwork\\CheckThreeDSAuthenticationResponse',
        'checkThreeDSAuthenticationResult' => 'Lyranetwork\\CheckThreeDSAuthenticationResult',
        'updatePayment' => 'Lyranetwork\\UpdatePayment',
        'updatePaymentResponse' => 'Lyranetwork\\UpdatePaymentResponse',
        'updatePaymentResult' => 'Lyranetwork\\UpdatePaymentResult',
        'updatePaymentDetails' => 'Lyranetwork\\UpdatePaymentDetails',
        'shoppingCartRequest' => 'Lyranetwork\\ShoppingCartRequest',
        'updatePaymentDetailsResponse' => 'Lyranetwork\\UpdatePaymentDetailsResponse',
        'updatePaymentDetailsResult' => 'Lyranetwork\\UpdatePaymentDetailsResult',
        'getPaymentDetails' => 'Lyranetwork\\GetPaymentDetails',
        'extendedResponseRequest' => 'Lyranetwork\\ExtendedResponseRequest',
        'getPaymentDetailsResponse' => 'Lyranetwork\\GetPaymentDetailsResponse',
        'getPaymentDetailsResult' => 'Lyranetwork\\GetPaymentDetailsResult',
        'tokenResponse' => 'Lyranetwork\\TokenResponse',
        'updateToken' => 'Lyranetwork\\UpdateToken',
        'cardRequest' => 'Lyranetwork\\CardRequest',
        'updateTokenResponse' => 'Lyranetwork\\UpdateTokenResponse',
        'updateTokenResult' => 'Lyranetwork\\UpdateTokenResult',
        'cancelSubscription' => 'Lyranetwork\\CancelSubscription',
        'cancelSubscriptionResponse' => 'Lyranetwork\\CancelSubscriptionResponse',
        'cancelSubscriptionResult' => 'Lyranetwork\\CancelSubscriptionResult',
        'refundPayment' => 'Lyranetwork\\RefundPayment',
        'refundPaymentResponse' => 'Lyranetwork\\RefundPaymentResponse',
        'refundPaymentResult' => 'Lyranetwork\\RefundPaymentResult',
        'createTokenFromTransaction' => 'Lyranetwork\\CreateTokenFromTransaction',
        'createTokenFromTransactionResponse' => 'Lyranetwork\\CreateTokenFromTransactionResponse',
        'createTokenFromTransactionResult' => 'Lyranetwork\\CreateTokenFromTransactionResult',
        'verifyThreeDSEnrollment' => 'Lyranetwork\\VerifyThreeDSEnrollment',
        'techRequest' => 'Lyranetwork\\TechRequest',
        'verifyThreeDSEnrollmentResponse' => 'Lyranetwork\\VerifyThreeDSEnrollmentResponse',
        'verifyThreeDSEnrollmentResult' => 'Lyranetwork\\VerifyThreeDSEnrollmentResult',
        'validatePayment' => 'Lyranetwork\\ValidatePayment',
        'validatePaymentResponse' => 'Lyranetwork\\ValidatePaymentResponse',
        'validatePaymentResult' => 'Lyranetwork\\ValidatePaymentResult',
        'getPaymentUuid' => 'Lyranetwork\\GetPaymentUuid',
        'legacyTransactionKeyRequest' => 'Lyranetwork\\LegacyTransactionKeyRequest',
        'getPaymentUuidResponse' => 'Lyranetwork\\GetPaymentUuidResponse',
        'legacyTransactionKeyResult' => 'Lyranetwork\\LegacyTransactionKeyResult',
        'createPayment' => 'Lyranetwork\\CreatePayment',
        'createPaymentResponse' => 'Lyranetwork\\CreatePaymentResponse',
        'createPaymentResult' => 'Lyranetwork\\CreatePaymentResult',
        'createSubscription' => 'Lyranetwork\\CreateSubscription',
        'subscriptionRequest' => 'Lyranetwork\\SubscriptionRequest',
        'createSubscriptionResponse' => 'Lyranetwork\\CreateSubscriptionResponse',
        'createSubscriptionResult' => 'Lyranetwork\\CreateSubscriptionResult',
        'getSubscriptionDetails' => 'Lyranetwork\\GetSubscriptionDetails',
        'getSubscriptionDetailsResponse' => 'Lyranetwork\\GetSubscriptionDetailsResponse',
        'getSubscriptionDetailsResult' => 'Lyranetwork\\GetSubscriptionDetailsResult',
        'updateSubscription' => 'Lyranetwork\\UpdateSubscription',
        'updateSubscriptionResponse' => 'Lyranetwork\\UpdateSubscriptionResponse',
        'updateSubscriptionResult' => 'Lyranetwork\\UpdateSubscriptionResult',
        'cancelToken' => 'Lyranetwork\\CancelToken',
        'cancelTokenResponse' => 'Lyranetwork\\CancelTokenResponse',
        'cancelTokenResult' => 'Lyranetwork\\CancelTokenResult',
        'createToken' => 'Lyranetwork\\CreateToken',
        'createTokenResponse' => 'Lyranetwork\\CreateTokenResponse',
        'createTokenResult' => 'Lyranetwork\\CreateTokenResult',
        'findPayments' => 'Lyranetwork\\FindPayments',
        'findPaymentsResponse' => 'Lyranetwork\\FindPaymentsResponse',
        'findPaymentsResult' => 'Lyranetwork\\FindPaymentsResult',
        'transactionItem' => 'Lyranetwork\\TransactionItem',
        'getTokenDetails' => 'Lyranetwork\\GetTokenDetails',
        'getTokenDetailsResponse' => 'Lyranetwork\\GetTokenDetailsResponse',
        'getTokenDetailsResult' => 'Lyranetwork\\GetTokenDetailsResult',
    );

    private $shopId;
    private $mode;
    private $certificate;

    /**
     * Class constructor.
     *
     * @param array $options An array of config values
     * @param string $wsdl The WSDL file to use
     */
    public function __construct(array $options = array(), $wsdl = 'https://secure.payzen.eu/vads-ws/v5?wsdl')
    {
        foreach (self::$classmap as $key => $value) {
            if (! isset($options['classmap'][$key])) {
                $options['classmap'][$key] = $value;
            }
        }

        $ssl = array();
        if (isset($options['sni.enabled']) && $options['sni.enabled']) {
            $url = parse_url($wsdl);
            $ssl = array('SNI_enabled' => true, 'SNI_server_name' => $url['host']);

            unset($options['sni.enabled']);
        }

        $options = array_merge(array(
            'trace' => true,
            'exceptions' => true,
            'soapaction' => '',
            'cache_wsdl' => WSDL_CACHE_NONE,
            'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
            'connection_timeout' => self::TIMEOUT,
            'encoding' => 'UTF-8',
            'soap_version' => SOAP_1_2,
            'stream_context' => stream_context_create(
                array('ssl' => $ssl, 'http' => array('user_agent' => 'PHPSoapClient'))
            )
        ), $options);

        parent::__construct($wsdl, $options);
    }

    /**
     * Init API with merchant credentials.
     *
     * @param string $shopId
     * @param string $ctxMode
     * @param string $keyTest
     * @param string $keyProd
     * @return \Lyranetwork\WsApi
     */
    public function init($shopId, $ctxMode, $keyTest, $keyProd)
    {
        $this->mode = $ctxMode;
        $this->shopId = $shopId;
        $this->certificate = ($ctxMode === 'PRODUCTION') ? $keyProd : $keyTest;

        return $this;
    }

    /**
     * Compute WS signature based on two data in entry.
     *
     * @param string $data1
     * @param string $data2
     * @return string
     */
    public function getAuthToken($data1, $data2)
    {
        $authToken = base64_encode(hash_hmac('sha256', $data1 . $data2, $this->certificate, true));
        return $authToken;
    }

    /**
     * Set WS request headers. Return generated request ID.
     *
     * @return string
     */
    public function setHeaders()
    {
        $this->__setSoapHeaders(null);

        $requestId = self::genUuid();
        $timestamp = gmdate(self::DATE_FORMAT);
        $authToken = $this->getAuthToken($requestId, $timestamp);

        // create headers for shopId, requestId, timestamp, mode and authToken
        $headers = array();

        $headers[] = new \SOAPHeader(self::HEADER_NAMESPACE, 'shopId', $this->shopId);
        $headers[] = new \SOAPHeader(self::HEADER_NAMESPACE, 'requestId', $requestId);
        $headers[] = new \SOAPHeader(self::HEADER_NAMESPACE, 'timestamp', $timestamp);
        $headers[] = new \SOAPHeader(self::HEADER_NAMESPACE, 'mode', $this->mode);
        $headers[] = new \SOAPHeader(self::HEADER_NAMESPACE, 'authToken', $authToken);

        // set headers to soap client
        $this->__setSoapHeaders($headers);

        return $requestId;
    }

    /**
     * Get last successful request session ID.
     *
     * @throws \SoapFault if session ID cannot be extracted from headers
     * @return string
     */
    public function getJsessionId()
    {
        // retrieve header of the last response
        $header = $this->__getLastResponseHeaders();

        $matches = array();
        if (! preg_match('#JSESSIONID=([A-Za-z0-9\._]+)#', $header, $matches)) {
            // no session created by platform
            throw new \SoapFault('SID', 'No session ID returned by platform.' . $header);
        }

        return $matches[1];
    }

    /**
     * Force session ID to enchain WS calls.
     *
     * @param string $sid
     * @return \Lyranetwork\WsApi
     */
    public function setJsessionId($sid)
    {
        $this->__setCookie('JSESSIONID', $sid);

        return $this;
    }

    /**
     * Check response authenticity.
     *
     * @throws \UnexpectedValueException if data inconsistency is encountered.
     */
    public function checkAuthenticity()
    {
        // retrieve SOAP header to check response authenticity
        $dom = new \DOMDocument();
        $dom->loadXML($this->__getLastResponse(), LIBXML_NOWARNING);

        $path = new \DOMXPath($dom);
        $xmlHeaders = $path->query('//*[local-name()="Header"]/*');

        $headers = array();
        foreach ($xmlHeaders as $xmlHeader) {
            $headers[$xmlHeader->nodeName] = $xmlHeader->nodeValue;
        }

        if ($this->shopId !== $headers['shopId']) {
            throw new \UnexpectedValueException("Inconsistent returned shopId {$headers['shopId']}.", -1);
        }

        if ($this->mode !== $headers['mode']) {
            throw new \UnexpectedValueException("Inconsistent returned mode {$headers['mode']}.", -1);
        }

        $authToken = $this->getAuthToken($headers['timestamp'], $headers['requestId']);
        if ($authToken !== $headers['authToken']) {
            throw new \UnexpectedValueException('Authentication failed.', -1);
        }
    }

    /**
     * Check response results (result code and expected transcation statuses if any).
     *
     * @param \Lyranetwork\CommonResponse $commonResponse
     * @param array $expectedStatuses
     * @throws \UnexpectedValueException
     */
    public function checkResult(\Lyranetwork\CommonResponse $commonResponse, array $expectedStatuses = array())
    {
        if ($commonResponse->getResponseCode() !== 0) {
            throw new \UnexpectedValueException(
                $commonResponse->getResponseCodeDetail(),
                $commonResponse->getResponseCode()
            );
        }

        if (! empty($expectedStatuses) && ! in_array($commonResponse->getTransactionStatusLabel(), $expectedStatuses)) {
            throw new \UnexpectedValueException(
                "Unexpected transaction status returned ({$commonResponse->getTransactionStatusLabel()})."
            );
        }
    }

    /**
     * Generate v4 UUID to use it as WS request ID.
     *
     * @return string
     */
    public static function genUuid()
    {
        if ($data = self::genRandomBytes()) {
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 100
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6 & 7 to 10

            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        } else {
            return sprintf(
                '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff),
                mt_rand(0, 0xffff)
            );
        }
    }

    private static function genRandomBytes()
    {
        if (function_exists('random_bytes')) {
            // PHP 7 code
            try {
                return random_bytes(16);
            } catch(\Exception $e) {
                // try something else below
            }
        }

        if (function_exists('openssl_random_pseudo_bytes')) {
            // PHP 5.3 code but needs OpenSSL library
            return openssl_random_pseudo_bytes(16);
        }

        return null;
    }

    /**
     * @param \Lyranetwork\CancelCapturedPayment $parameters
     * @return \Lyranetwork\CancelCapturedPaymentResponse
     */
    public function cancelCapturedPayment(\Lyranetwork\CancelCapturedPayment $parameters)
    {
        return $this->__soapCall('cancelCapturedPayment', array($parameters));
    }

    /**
     * @param \Lyranetwork\CapturePayment $parameters
     * @return \Lyranetwork\CapturePaymentResponse
     */
    public function capturePayment(\Lyranetwork\CapturePayment $parameters)
    {
        return $this->__soapCall('capturePayment', array($parameters));
    }

    /**
     * @param \Lyranetwork\CreateTokenByIban $parameters
     * @return \Lyranetwork\CreateTokenByIbanResponse
     */
    public function createTokenByIban(\Lyranetwork\CreateTokenByIban $parameters)
    {
        return $this->__soapCall('createTokenByIban', array($parameters));
    }

    /**
     * @param \Lyranetwork\ReactivateToken $parameters
     * @return \Lyranetwork\ReactivateTokenResponse
     */
    public function reactivateToken(\Lyranetwork\ReactivateToken $parameters)
    {
        return $this->__soapCall('reactivateToken', array($parameters));
    }

    /**
     * @param \Lyranetwork\DuplicatePayment $parameters
     * @return \Lyranetwork\DuplicatePaymentResponse
     */
    public function duplicatePayment(\Lyranetwork\DuplicatePayment $parameters)
    {
        return $this->__soapCall('duplicatePayment', array($parameters));
    }

    /**
     * @param \Lyranetwork\CancelPayment $parameters
     * @return \Lyranetwork\CancelPaymentResponse
     */
    public function cancelPayment(\Lyranetwork\CancelPayment $parameters)
    {
        return $this->__soapCall('cancelPayment', array($parameters));
    }

    /**
     * @param \Lyranetwork\CheckThreeDSAuthentication $parameters
     * @return \Lyranetwork\CheckThreeDSAuthenticationResponse
     */
    public function checkThreeDSAuthentication(\Lyranetwork\CheckThreeDSAuthentication $parameters)
    {
        return $this->__soapCall('checkThreeDSAuthentication', array($parameters));
    }

    /**
     * @param \Lyranetwork\UpdatePayment $parameters
     * @return \Lyranetwork\UpdatePaymentResponse
     */
    public function updatePayment(\Lyranetwork\UpdatePayment $parameters)
    {
        return $this->__soapCall('updatePayment', array($parameters));
    }

    /**
     * @param \Lyranetwork\UpdatePaymentDetails $parameters
     * @return \Lyranetwork\UpdatePaymentDetailsResponse
     */
    public function updatePaymentDetails(\Lyranetwork\UpdatePaymentDetails $parameters)
    {
        return $this->__soapCall('updatePaymentDetails', array($parameters));
    }

    /**
     * @param \Lyranetwork\GetPaymentDetails $parameters
     * @return \Lyranetwork\GetPaymentDetailsResponse
     */
    public function getPaymentDetails(\Lyranetwork\GetPaymentDetails $parameters)
    {
        return $this->__soapCall('getPaymentDetails', array($parameters));
    }

    /**
     * @param \Lyranetwork\UpdateToken $parameters
     * @return \Lyranetwork\UpdateTokenResponse
     */
    public function updateToken(\Lyranetwork\UpdateToken $parameters)
    {
        return $this->__soapCall('updateToken', array($parameters));
    }

    /**
     * @param \Lyranetwork\CancelSubscription $parameters
     * @return \Lyranetwork\CancelSubscriptionResponse
     */
    public function cancelSubscription(\Lyranetwork\CancelSubscription $parameters)
    {
        return $this->__soapCall('cancelSubscription', array($parameters));
    }

    /**
     * @param \Lyranetwork\RefundPayment $parameters
     * @return \Lyranetwork\RefundPaymentResponse
     */
    public function refundPayment(\Lyranetwork\RefundPayment $parameters)
    {
        return $this->__soapCall('refundPayment', array($parameters));
    }

    /**
     * @param \Lyranetwork\CreateTokenFromTransaction $parameters
     * @return \Lyranetwork\CreateTokenFromTransactionResponse
     */
    public function createTokenFromTransaction(\Lyranetwork\CreateTokenFromTransaction $parameters)
    {
        return $this->__soapCall('createTokenFromTransaction', array($parameters));
    }

    /**
     * @param \Lyranetwork\VerifyThreeDSEnrollment $parameters
     * @return \Lyranetwork\VerifyThreeDSEnrollmentResponse
     */
    public function verifyThreeDSEnrollment(\Lyranetwork\VerifyThreeDSEnrollment $parameters)
    {
        return $this->__soapCall('verifyThreeDSEnrollment', array($parameters));
    }

    /**
     * @param \Lyranetwork\ValidatePayment $parameters
     * @return \Lyranetwork\ValidatePaymentResponse
     */
    public function validatePayment(\Lyranetwork\ValidatePayment $parameters)
    {
        return $this->__soapCall('validatePayment', array($parameters));
    }

    /**
     * @param \Lyranetwork\GetPaymentUuid $parameters
     * @return \Lyranetwork\GetPaymentUuidResponse
     */
    public function getPaymentUuid(\Lyranetwork\GetPaymentUuid $parameters)
    {
        return $this->__soapCall('getPaymentUuid', array($parameters));
    }

    /**
     * @param \Lyranetwork\CreatePayment $parameters
     * @return \Lyranetwork\CreatePaymentResponse
     */
    public function createPayment(\Lyranetwork\CreatePayment $parameters)
    {
        return $this->__soapCall('createPayment', array($parameters));
    }

    /**
     * @param \Lyranetwork\CreateSubscription $parameters
     * @return \Lyranetwork\CreateSubscriptionResponse
     */
    public function createSubscription(\Lyranetwork\CreateSubscription $parameters)
    {
        return $this->__soapCall('createSubscription', array($parameters));
    }

    /**
     * @param \Lyranetwork\GetSubscriptionDetails $parameters
     * @return \Lyranetwork\GetSubscriptionDetailsResponse
     */
    public function getSubscriptionDetails(\Lyranetwork\GetSubscriptionDetails $parameters)
    {
        return $this->__soapCall('getSubscriptionDetails', array($parameters));
    }

    /**
     * @param \Lyranetwork\UpdateSubscription $parameters
     * @return \Lyranetwork\UpdateSubscriptionResponse
     */
    public function updateSubscription(\Lyranetwork\UpdateSubscription $parameters)
    {
        return $this->__soapCall('updateSubscription', array($parameters));
    }

    /**
     * @param \Lyranetwork\CancelToken $parameters
     * @return \Lyranetwork\CancelTokenResponse
     */
    public function cancelToken(\Lyranetwork\CancelToken $parameters)
    {
        return $this->__soapCall('cancelToken', array($parameters));
    }

    /**
     * @param \Lyranetwork\CreateToken $parameters
     * @return \Lyranetwork\CreateTokenResponse
     */
    public function createToken(\Lyranetwork\CreateToken $parameters)
    {
        return $this->__soapCall('createToken', array($parameters));
    }

    /**
     * @param \Lyranetwork\FindPayments $parameters
     * @return \Lyranetwork\FindPaymentsResponse
     */
    public function findPayments(\Lyranetwork\FindPayments $parameters)
    {
        return $this->__soapCall('findPayments', array($parameters));
    }

    /**
     * @param \Lyranetwork\GetTokenDetails $parameters
     * @return \Lyranetwork\GetTokenDetailsResponse
     */
    public function getTokenDetails(\Lyranetwork\GetTokenDetails $parameters)
    {
        return $this->__soapCall('getTokenDetails', array($parameters));
    }
}
