<?php

// Process the callback data
$data = file_get_contents('php://input');

// Log the callback data (for testing purposes)
file_put_contents('callback_log.txt', $data);

// Decode the JSON data
$callback_data = json_decode($data);

// Check if the transaction was unsuccessful
if (isset($callback_data->Body->stkCallback->ResultCode) && $callback_data->Body->stkCallback->ResultCode != 0) {
    // Transaction was unsuccessful
    // Handle the unsuccessful transaction here
    // For example, log the transaction details or notify the user
    echo('success purchase');
    // You can access additional details such as $callback_data->Body->stkCallback->ResultDesc for error description
} else {
    // Transaction was successful
    // You can handle successful transactions here
    echo('Failed purchase');
}

// Respond with HTTP status 200
http_response_code(200);
?>

