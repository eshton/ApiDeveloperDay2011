<?php

### Set your Zend Framework, pear and php local path
$oldpath = set_include_path('.:/home/agoston/pear/share/pear:/usr/local/zend/share/pear:/usr/share/php');
### Set your BlueviaClient.php path
include_once "../bluevia/src/BlueviaClient.php";

class BUTESmsSender {

    private $debug = false;
    private $application_context;
    private $blueViaService;

    public function __construct($debug = false) {
        
        $this->debug = $debug;

        // BlueVia provides two environments to support the different development stages of your app.
        // Sandbox for testing, and Live for accessing the live network.
        // You can choose which of them to use depending on the API endpoint you need.
        BlueviaClient_Api_Constants::$environment  = BlueviaClient_Api_Constants::ENVIRONMENT_COMMERCIAL;

        // PHP SDK wraps any request to BlueVia API's by using a generic object BlueviaClient.
        // This object uses the Component Pattern to fetch any service required by the developer (oAuth, SMS, Directory or Advertising).
        // The BlueviaClient constructor requires an array containing the application consumer key, consumer secret and the access token data
        $this->application_context = array(
            'app' => array(
              'consumer_key' => 'yW11100122694730', //CONSUMER_KEY,
              'consumer_secret' => 'ubLv84674635' //CONSUMER_SECRET
            ),
                'user' => array(
              'token_access' => '24cb569005504d27a4e225966562dca7', //TOKEN,
              'token_secret' => '89e62b66dc252cd2b634880918f4c502' //TOKEN_SECRET,
            )
          );

        $this->blueViaService = new BlueviaClient($this->application_context);
    }

    public function send($msisdn, $message) {

	$sms = $this->blueViaService->getService('Sms');
	if ($sms)
	{
		$sms->addRecipient($msisdn);
		$sms->setMessage($message);
		$result = null;
		// Send SMS
		try{
			$result = $sms->send();
			if (defined('DEBUG') && constant('DEBUG')) {
				if($result) var_dump($result);
				print "<p style=\"color:blue\"> Request: ".$bv->getLastRequest()."</p>";
				print "<p style=\"color:blue\"> Response: ".$bv->getLastResponse()."</p>";
			}
		} catch (Exception $e) {
			print "<p> Error sending SMS: ".$e->getMessage()."</p>";
		}

		// Retrieve SMS delivery status
		try {
			$delivery_status = $sms->getDeliveryStatus($result);
			if (defined('DEBUG') && constant('DEBUG')) {
				if($delivery_status) var_dump($delivery_status);
				print "<p style=\"color:blue\"> Request: ".$bv->getLastRequest()."</p>";
				print "<p style=\"color:blue\"> Response: ".$bv->getLastResponse()."</p>";
			}
		} catch (Exception $e) {
			print "<p>Error retreiving the SMS delivery status: ".$e->getMessage()."</p>";
		}
/*
		// Get messages
		try {
			$received_messages = $sms->getMessages(SHORTCODE);
			if (defined('DEBUG') && constant('DEBUG')) {
				if($received_messages) var_dump($received_messages);
				print "<p style=\"color:blue\"> Request: ".$bv->getLastRequest()."</p>";
				print "<p style=\"color:blue\"> Response: ".$bv->getLastResponse()."</p>";
			}
		} catch(Exception $e) {
			print "<p>Error retrieving SMS".$e->getMessage()."</p>";
		}

		unset($sms);*/
	}
    }
}
