<?php
	
	session_start();
	
	include "connection.php";
	include "cart-class.php";	
	
	$id_comprador = $_SESSION['id'];
	if(isset($_SESSION['id_comprador'])) {
		$id_comprador = $_SESSION['id_comprador'];
	}
	$date = date('d-m-Y');
	$time = date('H:i:s');
	$sql = "
		INSERT INTO
			venda(data_venda, hora_venda, usuario)
		VALUES(
			'{$date}',
			'{$time}',
			{$id_comprador}
		);
		SELECT CURRVAL('venda_id_seq');
	";
	
	$id = pg_fetch_array(pg_query($connection, $sql));
	$id = $id[0];
	
	$sql = "
		INSERT INTO
			venda_item(id, produto, quantidade)
		VALUES
	";
	
	for($k = 0; $k < count($products); $k++) {
		$sql .= "
			(
				{$id},
				{$products[$k]['id']},
				{$products[$k]['amount']}
			)
		";
		if($k+1 < count($products)) {
			$sql .= ",";
		}
	}
	pg_query($connection, $sql);
	
	$sql = "
		DELETE FROM
			carrinho
		WHERE
			usuario = {$id_comprador}
	";
	pg_query($connection, $sql);
	
	for($k = 0; $k < count($products); $k++) {
		$sql = "
			UPDATE
				produto
			SET
				estoque = ".($products[$k]['stock'] - $products[$k]['amount'])."
			WHERE
				id = {$products[$k]['id']}
		";
		pg_query($connection, $sql);
	}
	
	setcookie("cart", null, time() - 3600);
	
	if($_SESSION['acesso'] = "adm") {
		header("location:sell.php");
	}
	else {
		header("location:purchase-completed.php");
	}
	
?>