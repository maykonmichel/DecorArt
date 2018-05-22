<?php

	include "connection.php";
	
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$name = $_POST['name'];
	$lastname = $_POST['last_name'];
	$genre = $_POST['genre'];
	$birthday = $_POST['birthday'];
	$rg = str_replace(".", "", $_POST['rg']);
	$rg = str_replace(".", "", $rg);
	$rg = str_replace("-", "", $rg);
	$cpf = str_replace(".", "", $_POST['cpf']);
	$cpf = str_replace(".", "", $cpf);
	$cpf = str_replace("/", "", $cpf);
	$telephone = str_replace("(", "", $_POST['telephone']);
	$telephone = str_replace(")", "", $telephone);
	$telephone = str_replace(" ", "", $telephone);
	$telephone = str_replace("-", "", $telephone);
	$cellphone = str_replace("(", "", $_POST['cellphone']);
	$cellphone = str_replace(")", "", $cellphone);
	$cellphone = str_replace(" ", "", $cellphone);
	$cellphone = str_replace("-", "", $cellphone);
	$address = $_POST['address'];
	$number = $_POST['number'];
	$block = $_POST['block'];
	$neighborhood = $_POST['neighborhood'];
	$complement = $_POST['complement'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$cep = $_POST['cep'];
	$cep = str_replace("-", "", $cep);
	$acess = $_POST['acess'];
	if(!isset($acess)) {
		$acess = "usuario";
	}
	
	$sql = "
		INSERT INTO 
			conta_usuario (email, senha, acesso)
		VALUES(
				'{$email}',
				'{$password}',
				'{$acess}');
		SELECT CURRVAL('conta_usuario_id_seq');
	"; echo $sql."<br>";
	$id = pg_fetch_array(pg_query($connection, $sql));
	$id = $id[0];
	
	$sql = "
		INSERT INTO 
			detalhes_usuario (id, nome, sobrenome, genero, data_nasc, rg, cpf, telefone, celular) 
		VALUES(
			{$id},
			'{$name}',
			'{$lastname}',
			'{$genre}',
			'{$birthday}',
			'{$rg}',
			{$cpf},
			{$telephone},
			".(empty($cellphone) ? "NULL" : $cellphone)."
		);
	"; echo $sql."<br>";
	pg_query($connection, $sql);
	
	$sql = "
		INSERT INTO 
			endereco (usuario, rua, numero, quadra, bairro, complemento, cidade, estado, cep)
		VALUES(
			{$id},
			'{$address}',
			{$number},
			".(empty($block) ? "NULL" : $block).",
			'{$neighborhood}',
			'".(empty($complement) ? "NULL" : $complement)."',
			'{$city}',
			'{$state}',
			{$cep}
		);
	"; echo $sql."<br>";
	pg_query($connection, $sql);
	
	pg_close($connection);
	
	if(isset($_POST['acess'])) {
		header("location:user.php");
	}
	else {
		header("location:signup-login.php?login");
	}
	
?>