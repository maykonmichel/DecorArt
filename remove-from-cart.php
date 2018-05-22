<?php

	session_start();
	
	$id = $_GET['id'];
	$amount = $_GET['amount'];

	$cart = $_COOKIE['cart'];
	$cart = json_decode($cart, true);
	
	if(!isset($amount)) {
		$cart[$id] = 0;
	}
	else {
		$cart[$id] -= 1;
	}
	
	if($cart[$id] <= 0) {
		unset($cart[$id]);
	}
		
	$json = json_encode($cart, true);
	setcookie("cart", $json, time() + 3600*24*30);
	
	if($_SESSION['id']) {
		if($_SESSION['acesso'] = "adm") {
			header("location:sell.php");
		}
		else {
			header("location:update-cart.php");
		}
	}
	else {
		header("location:cart.php");
	}

?>