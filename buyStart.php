<?php
require_once('./header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$error = false;

	try {
		
		if (!isset($_POST['stripeToken'])) throw new Exception("The Stripe Token was not generated correctly");
		$charge = \Stripe\Charge::create(array(
			'source'	=> $_POST['stripeToken'],
			'amount'	=> 1999,
			'currency'	=> 'usd',
			"description" => "Example charge"
			));

	} catch (Exception $e) {
		$error = $e->getMessage();
	}

	if (!$error) {
		
	echo "Something 1 worked!";

	}
	else {
		echo "There was some sort of error";
	}
} 

// require_once('./footer.php');