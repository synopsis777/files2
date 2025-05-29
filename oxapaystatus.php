
<?php 
//oxapaystatus.php
define("EvolutionScript", 1);
require_once("global.php");
$gateway = $db->fetchRow("SELECT * FROM gateways WHERE id=10");
$merchant_api_key = $gateway["account"];
$currency = $gateway["currency"];

// Extract posted values
$amount        = floatval($_POST['amount']);
$email         = $_POST['email'];
$callback_url  = $_POST['callback_url'];
$return_url    = $_POST['return_url'];
$item_name     = $_POST['item_name'];      // e.g. "Deposit" or "Upgrade"
$item_number   = $_POST['item_number'];    // usually user ID
$upgrade_id    = $_POST["custom"];    // will be effected when come from upgrade_form/10.php instead of deposit_form/10.php
$today = TIMENOW;
$batch=$track_id;

$order_id      = "ORD-" . uniqid($item_number . "-");
$description   = "{$item_name} by user #{$item_number}";


if ($response === FALSE) {
    die('Error contacting OxaPay.');
}

$result = json_decode($response, true);

if (!empty($result['data']['payment_url'])) {
    header("Location: " . $result['data']['payment_url']);
    exit;
} else {
    echo "<h2>Payment creation failed</h2>";
    echo "<pre>" . print_r($result, true) . "</pre>";
}
if( strcmp(trim($response), "VERIFIED") == 0 ) 
{
    if( $payment_status != "Success" ) 
    {
        exit();
    }

    if( $payment_currency != $currency ) 
    {
        exit();
    }

    if( is_numeric($upgrade_id) ) 
    {
        include(GATEWAYS . "process_upgrade.php");
    }
    else
    {
        include(GATEWAYS . "process_deposit.php");
    }

}
?>