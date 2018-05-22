<?php
	
	session_start();
	include "connection.php";
	include "cart-class.php";
	
	$sql = "
		DELETE FROM
			carrinho
		WHERE
			usuario = {$_SESSION['id']}
	";
	pg_query($connection, $sql);
	
	$sql = "
		INSERT INTO
			carrinho(usuario, produto, quantidade)
		VALUES
	";
	for($k = 0; $k < count($cart); $k++) {
		$sql .= "
			(
				{$_SESSION['id']},
				{$products[$k]['id']},
				{$products[$k]['amount']}
			)
		";
		if($k+1 < count($cart)) {
			$sql .= ",";
		}
	}
	pg_query($connection, $sql);	
	
	header("location:cart.php");
	
?>