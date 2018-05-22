<?php 

	session_start();
	include "connection.php"; 

	$date = date('d/m/Y'); 
	$id = $_GET['id'];
	
	$sql = "
		UPDATE
			conta_usuario 
		SET 
			data_exclusao = NULL
		WHERE
			id = {$id};
	";
	pg_query($connection,$sql);
	
	pg_close($connection);
	
	header("location:user.php");
	
?>