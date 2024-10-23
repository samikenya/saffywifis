<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize user input
    $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
    $amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_NUMBER_INT);

    if (empty($phone) || empty($amount)) {
        echo "Phone number and amount are required.";
        exit;
    }

    // Safaricom credentials
    $consumerKey = 'YOUR_CONSUMER_KEY';
    $consumerSecret = 'YOUR_CONSUMER_SECRET';

    // Access token URL
    $access_token_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

    // Initiate curl for access token
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $access_token_url);
    $credentials = base64_encode($consumerKey . ':' . $consumerSecret);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($curl);

    if ($response === false) {
        echo 'Curl error: ' . curl_error($curl);
        curl_close($curl);
        exit;
    }

    $result = json_decode($response);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo 'JSON decode error: ' . json_last_error_msg();
        curl_close($curl);
        exit;
    }

    $access_token = $result->access_token;
    curl_close($curl);

    // STK push URL
    $stk_push_url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

    // Prepare the STK push payload
    $stk_push_data = array(
        'BusinessShortCode' => '174379', // Test business short code
        'Password' => base64_encode('174379' . 'YOUR_PASSKEY' . date('YmdHis')),
        'Timestamp' => date('YmdHis'),
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $amount,
        'PartyA' => $phone,
        'PartyB' => '174379',
        'PhoneNumber' => $phone,
        'CallBackURL' => 'https://your-website.com/callback.php',
        'AccountReference' => 'Test123',
        'TransactionDesc' => 'Payment for goods'
    );

    // Initiate curl for STK push
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $stk_push_url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $access_token));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($stk_push_data));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($curl);

    if ($response === false) {
        echo 'Curl error: ' . curl_error($curl);
        curl_close($curl);
        exit;
    }

    curl_close($curl);

    echo $response;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STK Push Payment</title>
</head>
<body>
    <h2>STK Push Payment</h2>
    <form action="" method="post">
        <label for="phone">Phone Number:</label><br>
        <input type="text" id="phone" name="phone" required><br>
        <label for="amount">Amount:</label><br>
        <input type="number" id="amount" name="amount" required><br><br>
        <input type="submit" value="Pay Now">
    </form>
</body>
</html>