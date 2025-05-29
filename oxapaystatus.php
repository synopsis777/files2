<?php
define("EvolutionScript", 1);
require_once("global.php");

// Gateway info
$gateway = $db->fetchRow("SELECT * FROM gateways WHERE id=10");

// Variable mapping
$batch = $_POST["trackId"];
$receiver_email = $gateway["option1"]; // can be blank or admin email for OxaPay
$customer = $_POST["email"];
$order_id = intval($_POST["orderId"]);
$today = TIMENOW;
$upgrade_id = $_POST["custom"] ?? null;
$amount = floatval($_POST["amount"]);
$payment_status = $_POST["status"] ?? '';
$payment_currency = $_POST["currency"] ?? '';
$response = $_POST["response"] ?? false;
$oxapay_currency = $gateway["currency"];

// Merchant key check (optional, mostly for PayPal flow)
if ($gateway["option1"] && strtolower($gateway["option1"]) != strtolower($receiver_email)) {
    exit();
}

// Validate OxaPay response
if ($response != true) {
    exit();
}
if ($payment_status != "Success") {
    exit();
}
if ($payment_currency != $oxapay_currency) {
    exit();
}
if (is_numeric($upgrade_id)) {
    include(GATEWAYS . "process_upgrade.php");
} else {
    include(GATEWAYS . "process_deposit.php");
}
?>
