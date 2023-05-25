<?php 
	include('init.php');
	
	\Stripe\Stripe::setApiKey("sk_test_M0G0iu5gBPYX4PA1pX2xYLjq");
	
	$customer = \Stripe\Customer::create(array(
	  "description" => "rohit.bajariya@gmail.com",
	  "source" => "tok_amex",
		"email"=>'rohit.bajariya@gmail.com'	
	));	
	$customer_id=$customer['id'];	
	try{
	    $token=\Stripe\Token::create(array(
		    "card" => array(
				"number" => "4242424242424242",
				"exp_month" => 7,
				"exp_year" => 2018,
				"cvc" => "314"
		    )
		));	
		echo $token=$token['id'];
	}catch(Exception $e){
		print_r($e);
	}
?>