<?php
	
	include "connection.php";
	session_start();
	
	$email = $_POST['email_login'];
	if(isset($_POST['password_login'])) {
		$_SESSION['password'] = $_POST['password_login'];
	}
	$password = md5($_POST['password_login']);
	
	$sql = "
		SELECT
			conta_usuario.*,
			detalhes_usuario.nome,
			detalhes_usuario.sobrenome,
			detalhes_usuario.genero,
			detalhes_usuario.data_nasc,
			detalhes_usuario.rg,
			detalhes_usuario.cpf,
			detalhes_usuario.telefone,
			detalhes_usuario.celular,
			endereco.rua,
			endereco.numero,
			endereco.quadra,
			endereco.bairro,
			endereco.complemento,
			endereco.cidade,
			endereco.estado,
			endereco.cep
		FROM
			conta_usuario
		FULL JOIN
			detalhes_usuario
		ON
			conta_usuario.id = detalhes_usuario.id
		FULL JOIN 
			endereco
		ON
			conta_usuario.id = endereco.usuario
		WHERE
			conta_usuario.data_exclusao IS NULL
		AND
	";
	
	if(isset($_SESSION['id'])) {
		$sql .= "
			conta_usuario.id = {$_SESSION['id']}
		";
	}
	else {
		$sql .= "
			email = '{$email}'
			AND senha = '{$password}'
		";
	}
	
	$result = pg_query($connection, $sql);
	$num_rows_user = pg_num_rows($result);
	if(!$num_rows_user) {
		$_SESSION['error'] = true;
		header("location:signup-login.php?login");
	}
	$user = pg_fetch_array($result);
	
	$sql = "
		SELECT
			*
		FROM
			carrinho
		WHERE
			usuario = {$user['id']}
	";
	$result = pg_query($connection, $sql);
	$num_rows = pg_num_rows($result);
	
	include "cart-class.php";
	
	if(!$num_rows && count($cart)) {
		$sql = "
			INSERT INTO
					carrinho(usuario, produto, quantidade)
				VALUES
		";
		for($k = 0; $k < count($cart); $k++) {
			$sql .= "
				(
					{$user['id']},
					{$products[$k]['id']},
					{$products[$k]['amount']}
				)
			";
			if($k+1 < count($cart)) {
				$sql .= ",";
			}
		}
		pg_query($connection, $sql);
	}
	else {
		$cart = array();
		for($k = 0; $k < $num_rows; $k++) {
			$sale = pg_fetch_array($result);
			$sql = "
				SELECT
					*
				FROM
					produto
				WHERE
					id = {$sale['produto']}
			";
			$product = pg_fetch_array(pg_query($connection, $sql));
			$cart[$product['id']] = $sale['quantidade'];
		}
		setcookie("cart", json_encode($cart, true), time() + 3600*24*30);
	}
	
	$_SESSION['id'] = $user['id'];
	$_SESSION['email'] = $user['email'];
	$_SESSION['name'] = $user['nome'];
	$_SESSION['last_name'] = $user['sobrenome'];
	$_SESSION['genre'] = $user['genero'];
	$_SESSION['birthday'] = date("d-m-Y", strtotime($user['data_nasc']));
	$_SESSION['rg'] = $user['rg'];
	$_SESSION['cpf'] = $user['cpf'];
	$_SESSION['telephone'] = $user['telefone'];
	$_SESSION['cellphone'] = $user['celular'];
	$_SESSION['address'] = $user['rua'];
	$_SESSION['number'] = $user['numero'];
	$_SESSION['block'] = $user['quadra'];
	$_SESSION['neighborhood'] = $user['bairro'];
	$_SESSION['complement'] = $user['complemento'];
	$_SESSION['city'] = $user['cidade'];
	$_SESSION['state'] = $user['estado'];
	$_SESSION['cep'] = $user['cep'];
	$_SESSION['acess'] = $user['acesso'];
	if($num_rows_user) {
		header("location:my-account.php");
	}

?>