<?php

    /**
     *
     * @author Mubashir Ali
     * saad_ali6@yahoo.com
     * @copyright GNU
     * @example example.php
     * @filesource class.refund.php
     * @version 1.0
     *
     * This PayPal API provides the functionality of Refunding Amount.
     * Credentials are omitted from here for privacy purpose. To use it credentials are compulsory to provide.
     */
    class PayPalRefund
    {
        private $API_Username, $API_Password, $Signature, $API_Endpoint, $version;
        function __construct($mode = "sandbox")
        {
            if($mode == "live")
            {
                $this->API_Username = "sgratman_api1.gmail.com";
                $this->API_Password = "PPQWEMKLLSRW6JUQ";
                $this->Signature = "A38x3SY1-yh0emnv7UrJ3ocEf4aYAwA1xvw2lUZBthkMwqrXNeGPsnMU";
                $this->API_Endpoint = "https://api-3t.paypal.com/nvp";
            }
            else
            {	// Sandbox Test Mode
                $this->API_Username = "sgratman-facilitator_api1.gmail.com";
                $this->API_Password = "V882P8JLWVAHPEAF";            
                $this->Signature = "AFcWxV21C7fd0v3bYYYRCpSSRl31A9yhF3NqmOfOPpQTsrOAQclCaTWf";
                $this->API_Endpoint = "https://api-3t.sandbox.paypal.com/nvp";
            }
            $this->version = "51.0";
        }

        /**
         * This function actually Sends the CURL Request for Refund
         * @param string - $requestString
         * @return array - returns the response
         */
        function sendRefundRequest($requestString)
        {
            $this->API_UserName  = urlencode($this->API_Username);
            $this->API_Password  = urlencode($this->API_Password);
            $this->API_Signature = urlencode($this->Signature);

            $this->version = urlencode($this->version);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->API_Endpoint);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);

            // Set the API operation, version, and API signature in the request.
            $reqStr = "METHOD=RefundTransaction&VERSION={$this->version}&PWD={$this->API_Password}&USER={$this->API_UserName}&SIGNATURE={$this->API_Signature}$requestString";

            // Set the request as a POST FIELD for curl.
            curl_setopt($ch, CURLOPT_POSTFIELDS, $reqStr);

            // Get response from the server.
            $curlResponse = curl_exec($ch);

            if(!$curlResponse)
                return array("ERROR_MESSAGE"=>"RefundTransaction failed".curl_error($ch)."(".curl_errno($ch).")");

            // Extract the response details.
            $httpResponseAr = explode("&", $curlResponse);

            $aryResponse = array();
            foreach ($httpResponseAr as $i => $value)
            {
                $tmpAr = explode("=", $value);
                if(sizeof($tmpAr) > 1)
                {
                    $aryResponse[$tmpAr[0]] = urldecode($tmpAr[1]);
                }
            }

            if((0 == sizeof($aryResponse)) || !array_key_exists('ACK', $aryResponse))
                return array("ERROR_MESSAGE"=>"Invalid HTTP Response for POST request ($reqStr) to {$this->API_Endpoint}");

            return $aryResponse;
        }

        /**
         * @param array $aryData
         * @return array
         */
        function refundAmount($aryData)
        {
            if(trim(@$aryData['currencyCode'])=="")
                return array("ERROR_MESSAGE"=>"Currency Code is Missing");
            if(trim(@$aryData['refundType'])=="")
                return array("ERROR_MESSAGE"=>"Refund Type is Missing");
            if(trim(@$aryData['transactionID'])=="")
                return array("ERROR_MESSAGE"=>"Transaction ID is Missing");

            $requestString = "&TRANSACTIONID={$aryData['transactionID']}&REFUNDTYPE={$aryData['refundType']}&CURRENCYCODE={$aryData['currencyCode']}";

            if(trim(@$aryData['invoiceID'])!="")
                $requestString = "&INVOICEID={$aryData['invoiceID']}";

            if(isset($aryData['memo']))
                $requestString .= "&NOTE={$aryData['memo']}";

            if(strcasecmp($aryData['refundType'], 'Partial') == 0)
            {
                if(!isset($aryData['amount']))
                {
                    return array("ERROR_MESSAGE"=>"For Partial Refund - It is essential to mention Amount");
                }
                else
                {
                    $requestString = $requestString."&AMT={$aryData['amount']}";
                }

                if(!isset($aryData['memo']))
                {
                    return array("ERROR_MESSAGE"=>"For Partial Refund - It is essential to enter text for Memo");
                }
            }

            $resCurl = $this->sendRefundRequest($requestString);
            return $resCurl;
        }
    }
?>