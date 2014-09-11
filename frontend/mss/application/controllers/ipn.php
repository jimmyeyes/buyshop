<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Ipn extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index() {

            $mc_gross=$this -> input -> get_post("mc_gross");
            $protection_eligibility=$this -> input -> get_post("protection_eligibility");
            $address_status=$this -> input -> get_post("address_status");
            $payer_id=$this -> input -> get_post("payer_id");
            $tax=$this -> input -> get_post("tax");
            $address_street=$this -> input -> get_post("address_street");
            $payment_date=$this -> input -> get_post("payment_date");
            $payment_status=$this -> input -> get_post("payment_status");
            $charset=$this -> input -> get_post("charset");
            $address_zip=$this -> input -> get_post("address_zip");
            $first_name=$this -> input -> get_post("first_name");
            $mc_fee=$this -> input -> get_post("mc_fee");
            $address_country_code=$this -> input -> get_post("address_country_code");
            $address_name=$this -> input -> get_post("address_name");
            $notify_version=$this -> input -> get_post("notify_version");
            $custom=$this -> input -> get_post("custom");
            $payer_status=$this -> input -> get_post("payer_status");
            $address_country=$this -> input -> get_post("address_country");
            $address_city=$this -> input -> get_post("address_city");
            $verify_sign=$this -> input -> get_post("verify_sign");
            $payer_email=$this -> input -> get_post("payer_email");
            $txn_id=$this -> input -> get_post("txn_id");
            $payment_type=$this -> input -> get_post("payment_type");
            $last_name=$this -> input -> get_post("last_name");
            $address_state=$this -> input -> get_post("address_state");
            $receiver_email=$this -> input -> get_post("receiver_email");
            $payment_fee=$this -> input -> get_post("payment_fee");
            $receiver_id=$this -> input -> get_post("receiver_id");
            $txn_type=$this -> input -> get_post("txn_type");
            $item_name=$this -> input -> get_post("item_name");
            $mc_currency=$this -> input -> get_post("mc_currency");
            $item_number=$this -> input -> get_post("item_number");
            $residence_country=$this -> input -> get_post("residence_country");
            $test_ipn=$this -> input -> get_post("test_ipn");
            $handling_amount=$this -> input -> get_post("handling_amount");
            $transaction_subject=$this -> input -> get_post("transaction_subject");
            $payment_gross=$this -> input -> get_post("payment_gross");
            $shipping=$this -> input -> get_post("shipping");



        // STEP 1: read POST data

        // Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
        // Instead, read raw POST data from the input stream.
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
          $keyval = explode ('=', $keyval);
          if (count($keyval) == 2)
             $myPost[$keyval[0]] = urldecode($keyval[1]);
        }

        print_r( $myPost);
        // read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
        $req = 'cmd=_notify-validate';
        if(function_exists('get_magic_quotes_gpc')) {
           $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
           if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
           } else {
                $value = urlencode($value);

           }
           $req .= "&$key=$value";

        }


        // STEP 2: POST IPN data back to PayPal to validate

        $ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        // In wamp-like environments that do not come bundled with root authority certificates,
        // please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set
        // the directory path of the certificate as shown below:
        // curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');

        if( !($res = curl_exec($ch)) ) {
            // error_log("Got " . curl_error($ch) . " when processing IPN data");
            curl_close($ch);
            exit;
        }
        curl_close($ch);


        // STEP 3: Inspect IPN validation result and act accordingly

        if (strcmp ($res, "VERIFIED") == 0) {
            // The IPN is verified, process it:
            // check whether the payment_status is Completed
            // check that txn_id has not been previously processed
            // check that receiver_email is your Primary PayPal email
            // check that payment_amount/payment_currency are correct
            // process the notification

            // assign posted variables to local variables
            $item_name = $_POST['item_name'];
            $item_number = $_POST['item_number'];
            $payment_status = $_POST['payment_status'];
            $payment_amount = $_POST['mc_gross'];
            $payment_currency = $_POST['mc_currency'];
            $txn_id = $_POST['txn_id'];
            $receiver_email = $_POST['receiver_email'];
            $payer_email = $_POST['payer_email'];


                $sql="insert into paypalipn values (null,";
            $sql.="'".$mc_gross."','".$protection_eligibility."','".$address_status."','".$payer_id."','".$tax."','".$address_street."','".$payment_date."','".$payment_status."','".$charset."','".$address_zip."','".$first_name."','".$mc_fee."'";
            $sql.=",'".$address_country_code."','".$address_name."','".$notify_version."','".$custom."','".$payer_status."','".$address_country."','".$address_city."','".$verify_sign."','".$payer_email."','".$txn_id."','".$payment_type."',";
            $sql.="'".$last_name."','".$address_state."','".$receiver_email."','".$payment_fee."','".$receiver_id."','".$txn_type."','".$item_name."','".$mc_currency."','".$item_number."','".$residence_country."','".$test_ipn."','".$handling_amount."','".$transaction_subject."','".$payment_gross."','".$shipping."',";
            $sql.="NOW())";

            $this->db->query($sql);
            // IPN message values depend upon the type of notification sent.
            // To loop through the &_POST array and print the NV pairs to the screen:
            foreach($_POST as $key => $value) {
              echo $key." = ". $value."<br>";
            }
        } else if (strcmp ($res, "INVALID") == 0) {
            // IPN invalid, log for manual investigation



            echo "The response from IPN was: <b>" .$res ."</b>";
        }


	
	}


    function SearchTransaction(){
        $PF_USER="jwliu_api1.me.com";
        $PF_PWD="1376929173";
        $PF_SIG="AFcWxV21C7fd0v3bYYYRCpSSRl31AvPRMD10WNGaVSVG.9ERCRjUMZE3";
        $PF_METHOD="TransactionSearch";


        $methodName_=$PF_METHOD;

        $sdate=date('Y-m-d') ;
        $edate=date("Y-m-d", strtotime("+1 day", strtotime($sdate)));


    // Add request-specific fields to the request string.
        $nvpStr_ = "&TRXTYPE=Q&STARTDATE=".$sdate."T0:0:0&ENDDATE=".$edate."T24:0:0";
        echo $nvpStr_;

        $environment = 'sandbox';
        // Set up your API credentials, PayPal end point, and API version.
        $API_UserName = urlencode($PF_USER);
        $API_Password = urlencode($PF_PWD);
        $API_Signature = urlencode($PF_SIG);
        $API_Endpoint = "https://api-3t.paypal.com/nvp";
        if("sandbox" === $environment || "beta-sandbox" === $environment) {
            $API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
        }


        $version = urlencode('78.0');

        // Set the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        // Turn off the server and peer verification (TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        // Set the API operation, version, and API signature in the request.
        $nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

        // Set the request as a POST FIELD for curl.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

        // Get response from the server.
        $httpResponse = curl_exec($ch);

        if(!$httpResponse) {
            exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
        }

        // Extract the response details.
        $httpResponseAr = explode("&", $httpResponse);

        $httpParsedResponseAr = array();
        foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if(sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }

        if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
        }

        print_r($httpParsedResponseAr);

        if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {

            $count=((count($httpParsedResponseAr)-5)/11);
            for($i=0;$i<$count;$i++){

                $TIMESTAMP= urldecode($httpParsedResponseAr["L_TIMESTAMP$i"]);
                $TIMEZONE= urldecode($httpParsedResponseAr["L_TIMEZONE$i"]);
                $TYPE= urldecode($httpParsedResponseAr["L_TYPE$i"]);
                $EMAIL= urldecode($httpParsedResponseAr["L_EMAIL$i"]);
                $NAME= urldecode($httpParsedResponseAr["L_NAME$i"]);
                $TRANSACTIONID= urldecode($httpParsedResponseAr["L_TRANSACTIONID$i"]);
                $STATUS= urldecode($httpParsedResponseAr["L_STATUS$i"]);
                $AMT= urldecode($httpParsedResponseAr["L_AMT$i"]);
                $CURRENCYCODE= urldecode($httpParsedResponseAr["L_CURRENCYCODE$i"]);
                $FEEAMT= urldecode($httpParsedResponseAr["L_FEEAMT$i"]);
                $NETAMT= urldecode($httpParsedResponseAr["L_NETAMT$i"]);

                $sql="select count(paypaltransactionid) as co from  paypaltransaction where TIMESTAMP='$TIMESTAMP' and TIMEZONE='$TIMEZONE'  and AMT='$AMT' and EMAIL='$EMAIL' and TRANSACTIONID='$TRANSACTIONID'";
                $query=$this->db->query($sql)->row();

                if($query->co =="0"){
                    $sql="insert into paypaltransaction values ('','".$TIMESTAMP."','".$TIMEZONE."','".$TYPE."','".$EMAIL."',\"".$NAME."\",'".$TRANSACTIONID."','".$STATUS."','".$AMT."','".$CURRENCYCODE."','".$FEEAMT."','".$NETAMT."',NOW())";
                    $this->db->query($sql);

                    $this->all_model->GetTransactionDetails($TRANSACTIONID);
                    echo "insert:"+$TRANSACTIONID;
                }else{
                    echo "hasdata";
                }

            }


        //exit('GetTransactionDetails Completed Successfully: '.print_r($httpParsedResponseAr, true));
    } else  {
        exit('GetTransactionDetails failed: ' . print_r($httpParsedResponseAr, true));
    }


    }


    function getdetail(){
                $this->all_model->GetTransactionDetails("68995986HC9802415");


    }
	

	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
