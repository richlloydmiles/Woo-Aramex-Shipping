<?php //server.php
require __DIR__ . '\inventory_functions.php';
ini_set("soap.wsdl_cache_enabled", "0"); // disabling WSDL cache
$server = new SoapServer(__DIR__  . "\inventory.wsdl");
$server->addFunction("getItemCount");
$server->handle();
