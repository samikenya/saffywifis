<?php
$amount=$_POST["amount"];
if($amount==0){
    echo('Can`t pay Ksh: '.$amount);
    exit();
}

$consumerKey='GEbw20blouHEWfGCTGcGahrTZkJ1yQcG';
$consumerSecret='6FwtamyAnR5hSMPb';
$passkey='bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919'; 
$shortcode='174379';

// Function to initiate STK push
function initiateStkPush() {
    global $consumerKey, $consumerSecret, $shortcode, $passkey;

    $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . base64_encode($consumerKey . ':' . $consumerSecret)]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $token = json_decode(curl_exec($curl));
    curl_close($curl);

    $access_token = $token->access_token;

    $timestamp = date('YmdHis');
    $password = base64_encode($shortcode . $passkey . $timestamp);

    $stk_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $stk_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $access_token));
    $curl_post_data = array(
        'BusinessShortCode' => $shortcode,
        'Password' => $password,
        'Timestamp' => $timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' =>$_POST["amount"],
        'PartyA' =>$_POST["phonenumber"],
        'PartyB' => $shortcode,
        'PhoneNumber' =>$_POST["phonenumber"],
        'CallBackURL' =>  'https://4e42-197-248-72-123.ngrok-free.app/website/stk/callback.php', // Your callback URL
        'AccountReference' => 'SAMUEL MWANGI KAMAU',
        'TransactionDesc' => 'SAMUEL'
    );

    $data_string = json_encode($curl_post_data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
    $curl_response = curl_exec($curl);
    return $curl_response;
}

$response = initiateStkPush();
echo ("stk push sent");
?>
