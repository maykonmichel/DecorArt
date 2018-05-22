<?php 

	session_start();
	include "connection.php"; 

	$date = date('d/m/Y'); 
	$id = $_GET['id'];
	if(!isset($id)) {
		$id = $_SESSION['id'];
	}
	
	$sql = "
		UPDATE
			conta_usuario 
		SET 
			data_exclusao = '{$date}'
		WHERE
			id = {$id};
	";
	pg_query($connection,$sql);
	
	pg_close($connection);
	
	if(isset($_GET['id'])) {
		header("location:user.php");
	}
	else {
		header("location:logout.php");
	}
	
?>