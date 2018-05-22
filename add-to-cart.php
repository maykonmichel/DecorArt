<?php	
	
	session_start();
	
	include "connection.php";
	
	$sql = "
		SELECT
			*
		FROM
			produto
		WHERE
			id = {$_GET['id']}
	";
	
	$product = pg_fetch_array(pg_query($connection, $sql));
	
	$cart = $_COOKIE['cart'];
	$cart = json_decode($cart, true);
	
	if(!$cart) {
		$cart = array();
	}
	if(array_key_exists($product['id'], $cart))
		$cart[$product['id']] += $_GET['amount'];
	else
		$cart[$product['id']] = $_GET['amount'];
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