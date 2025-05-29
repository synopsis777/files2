<?php 
if( !defined("EvolutionScript") ) 
{
    exit( "Hacking attempt..." );
}

$processor_form = "\r\n<form action=\"[site_url]modules/gateways/10_process.php\" method=\"post\" id=\"checkout[id]\">\r\n<input type=\"hidden\" name=\"cmd\" value=\"_xclick\">\r\n<input type=\"hidden\" name=\"business\" value=\"[merchant]\">\r\n<input type=\"hidden\" name=\"item_name\" value=\"[itemname]\">\r\n<input type=\"hidden\" name=\"item_number\" value=\"[userid]\">\r\n<input type=\"hidden\" name=\"currency_code\" value=\"[currency]\">\r\n<input type=\"hidden\" value=\"1\" name=\"no_note\"/>\r\n<input type=\"hidden\" value=\"1\" name=\"no_shipping\"/>\r\n<input type=\"hidden\" name=\"amount\" id=\"amount[id]\" value=\"[price]\">\r\n<input type=\"hidden\" name=\"return\" value=\"[site_url]modules/gateways/thankyou2.php\">\r\n<input type=\"hidden\" name=\"cancel_return\" value=\"[site_url]modules/gateways/upgrade.php\">\r\n<input type=\"hidden\" name=\"notify_url\" value=\"[site_url]modules/gateways/oxapaystatus.php\">\r\n<input type=\"hidden\" name=\"custom\" value=\"\" id=\"upgrade[id]\" />\r\n</form>\r\n";
?>