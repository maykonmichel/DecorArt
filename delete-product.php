<?php 
	include "connection.php"; 

	$data = date('d/m/Y'); 
	$id = $_GET['id'];
	
	$sql = "
		UPDATE 
			produto 
		SET 
			data_exclusao = '$data'
			where id = $id;
	";
	
	pg_query($connection,$sql);
	
	pg_close($connection);
	header("location:products.php");
?>