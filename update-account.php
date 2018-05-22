<?php

    session_start();
    include "connection.php"; 
     
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$name = $_POST['name'];
	$last_name = $_POST['last_name'];
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
	$quadra = $_POST['quadra'];
	$neighborhood = $_POST['neighborhood'];
	$complement = $_POST['complement'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$cep = $_POST['cep'];
	$cep = str_replace("-", "", $cep);
	$acess = $_POST['acess'];echo $_POST['acess']."<br>";
	if(empty($acess)) {
		$acess = "usuario";
	}
	$id = $_POST['id'];
	if(empty($id)) {
		$id = $_SESSION['id'];
	}
	
	$sql = "
		UPDATE
			conta_usuario
		SET                    
			email = '{$email}',
			senha = '{$password}',
			acesso = '{$acess}'
		WHERE
			id = {$id};
	";
	pg_query($connection, $sql); echo $sql;
	 
	$sql = "
		UPDATE 
			detalhes_usuario
		SET		
			nome = '{$name}',
			sobrenome = '{$last_name}',
			genero = '{$genre}',
			data_nasc = '{$birthday}',
			rg = '{$rg}',
			cpf = {$cpf},
			telefone = {$telephone}, 
			celular = ".(empty($cellphone) ? "NULL" : $cellphone)."
		WHERE
			id = {$id};
	";
	pg_query($connection, $sql); echo $sql;
	 
	$sql = "
		UPDATE 
			endereco
		SET
			rua = '{$address}',
			numero = {$number},
			quadra = ".(empty($quadra) ? "NULL" : $quadra).",
			bairro = '{$neighborhood}',
			complemento = ".(empty($complement) ? "NULL" : "'".$complement."'").",
			cidade = '{$city}',
			estado = '{$state}',
			cep = {$cep}
		WHERE 
			usuario = {$id};
	";   
	pg_query($connection, $sql); echo $sql;
	 
	pg_close($connection);
	
	if($_POST['state_account']) {
		$_POST['state_account'] == "inactive"
			? header("location:delete-account.php?id=".$id)
			: header("location:reactivate-account.php?id=".$id);
	}
	else if(isset($_POST['id'])) {
		header("location:user.php");
	}
	else {
		header("location:login.php");
	}
		
?>