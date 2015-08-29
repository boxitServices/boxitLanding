	<!DOCTYPE html>
	<html>
	<head>
		<title>BoxIT Services</title>
	</head>
	<body>
	<div id="container">
<?php
	require_once('stripePHP/init.php');
	$stripe = array(
	// granted, let's start with TEST keys first !
		// input secret stripe API key below
		'secret_key'		=> '',
		// input publishable stripe API key below
		'publishable_key' 	=> '';
		);
	\Stripe\Stripe::setApiKey($stripe['secret_key']);

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$charge = \Stripe\Charge::create(array(
			'source'	=> $_POST['stripeToken'],
			'amount'	=> 1999,
			'currency'	=> 'usd'
			));

		echo "Something 1 worked!";
	}
	else
	{ ?>
		<h2>
			Something 2 Happened!
		</h2>
		<h3>
			What does this mean for us?
		</h3>
		
		
	}
	</div>

	</body>
	</html>