<?php
	include "connection.php";
	
	$nome = $_POST['nome'];
	$tipo = $_POST['tipo'];
	$tema = $_POST['tema'];
	$altura = $_POST['altura'];
	$largura = $_POST['largura'];
	$preco = $_POST['preco'];
	$imagem = $_POST['imagem'];
	$estoque = $_POST['estoque'];
	$link = $_POST['imagem'];
	$referencia = "produto";
	
	$sql = "
		INSERT INTO 
			imagem (link, referencia)	
		VALUES(
				'$link',
				'$referencia');
		SELECT CURRVAL('imagem_id_seq');
	";

	$resultado = pg_query($connection, $sql);
	$id = pg_fetch_array($resultado);
	$id = $id[0];

	$sql = "
		INSERT INTO 
			produto (nome, tipo, tema, altura, largura, preco, imagem, estoque)
		VALUES(
				'$nome',
				'$tipo',
				'$tema',
				$altura,
				$largura,
				'$preco',
				'$id',
				'$estoque')
	";
				  
	pg_query($connection, $sql);

	pg_close($connection);
	header("location:products.php");
?>