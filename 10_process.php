<?php
define("EvolutionScript", 1);
require_once("global.php");

$order_id = intval($_POST['order_id']); // user_id = order_id
$amount = floatval($_POST['amount']);
$email = $_POST['email'];
$customer = $email; // for deposit_history
$track_id = uniqid("TRK_{$order_id}_"); // or any unique logic

$gateway = $db->fetchRow("SELECT * FROM gateways WHERE id=10");
$merchant_api_key = $gateway["account"];

// OxaPay API
$url = 'https://api.oxapay.com/merchants/request';

$data = [
    'merchant'      => $merchant_api_key,
    'amount'        => $amount,
    'currency'      => 'USDT',
    'lifeTime'      => 45,
    'feePaidByPayer'=> 1,
    'underPaidCover'=> 2,
    'callbackUrl'   => 'https://traffictask.online/modules/gateways/oxapaystatus.php',
    'returnUrl'     => 'https://traffictask.online/modules/gateways/payment-success.php?order_id=' . $order_id,
    'description'   => 'Deposit for user #' . $order_id,
    'orderId'       => $order_id,
    'trackId'       => $track_id,
    'email'         => $email,
    'sandbox'       => true // or false for production
];

$options = [
    'http' => [
        'header'  => "Content-Type: application/json\r\n" .
                     "Authorization: Bearer {$merchant_api_key}\r\n",
        'method'  => 'POST',
        'content' => json_encode($data)
    ]
];

$context  = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response === false) {
    die("Error: Payment request failed (no response).");
}

$result = json_decode($response, true);

if (empty($result['payLink'])) {
    die("Error: Payment link not generated. Response: " . json_encode($result, JSON_PRETTY_PRINT));
}

// Redirect user to OxaPay payment page
header("Location: " . $result['payLink']);
exit;
?>
