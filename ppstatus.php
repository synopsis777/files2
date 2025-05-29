<?php 
//ppstatus.php
define("EvolutionScript", 1);
require_once("global.php");
$gateway = $db->fetchRow("SELECT * FROM gateways WHERE id=2");
$pp_account = $gateway["account"];
$pp_currency = $gateway["currency"];
$req = "cmd=_notify-validate";
foreach( $_POST as $key => $value ) 
{
    $value = urlencode(stripslashes($value));
    $req .= "&" . $key . "=" . $value;
}
$test = "yes";
$paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";

$username = $_POST["custom"];
$item_name = $_POST["item_name"];
$order_id = $_POST["item_number"];
$payment_status = $_POST["payment_status"];
$amount = $_POST["mc_gross"];
$payment_currency = $_POST["mc_currency"];
$batch = $_POST["txn_id"];
$receiver_email = $_POST["receiver_email"];
$customer = $_POST["payer_email"];
$today = TIMENOW;
$upgrade_id = $_POST["custom"];
if( strtolower($gateway["account"]) != strtolower($receiver_email) ) 
{
    exit();
}
$res = file_get_contents($paypal_url . "?" . $req);
if( strcmp(trim($res), "VERIFIED") == 0 ) 
{
    if( $payment_status != "Completed" ) 
    {
        exit();
    }
    if( $payment_currency != $pp_currency ) 
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