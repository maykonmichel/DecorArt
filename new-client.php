<?php

	session_start();
	include "connection.php";
	$sql = "
		INSERT INTO
			conta_usuario(email, senha, acesso)
		VALUES(
			'{$_POST['email']}',
			'e8d95a51f3af4a3b134bf6bb680a213a',
			'usuario'
		);
		SELECT CURRVAL('conta_usuario_id_seq');
	";
	
	$id_comprador = pg_fetch_array(pg_query($connection, $sql));
	$_SESSION['id_comprador'] = $id_comprador[0];
	header("location:checkout.php");

?>