<?php //client-test.php
// ini_set(plugin_dir_path( __FILE__ ) . "soap.wsdl_cache_enabled", "0"); // disabling WSDL cache
// $client = new SoapClient(plugin_dir_path( __FILE__ ) . "inventory.wsdl");
// $return = $client->getItemCount('19283');
// print_r($return);
// client support number CPT/0315/392 
$soapClient = new SoapClient(__DIR__  . '\inventory.wsdl');
	echo '<pre>';
	print_r($soapClient->__getFunctions());

	$params = array(
		'ClientInfo'  			=> array(
									'AccountCountryCode'	=> 'JO',
									'AccountEntity'		 	=> 'AMM',
									'AccountNumber'		 	=> '00000',
									'AccountPin'		 	=> '000000',
									'UserName'			 	=> 'user@company.com',
									'Password'			 	=> '000000000',
									'Version'			 	=> 'v1.0'
								),
								
		'Transaction' 			=> array(
									'Reference1'			=> '001' 
								),
								
		'OriginAddress' 	 	=> array(
									'City'					=> 'Amman',
									'CountryCode'				=> 'JO'
								),
								
		'DestinationAddress' 	=> array(
									'City'					=> 'Dubai',
									'CountryCode'			=> 'AE'
								),
		'ShipmentDetails'		=> array(
									'PaymentType'			 => 'P',
									'ProductGroup'			 => 'EXP',
									'ProductType'			 => 'PPX',
									'ActualWeight' 			 => array('Value' => 5, 'Unit' => 'KG'),
									'ChargeableWeight' 	     => array('Value' => 5, 'Unit' => 'KG'),
									'NumberOfPieces'		 => 5
								)
	);
	
	$results = $soapClient->CalculateRate($params);	
	
	echo '<pre>';
	print_r($results);
	die();
