<?php
	$stripe = array(
	// granted, let's start with TEST keys first !
		// input secret stripe API key below
		'secret_key'		=> '',
		// input publishable stripe API key below
		'publishable_key' 	=> 'pk_test_lXtA4BSX2EpzmbGMx6jBgoRt';
		);
	\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>
