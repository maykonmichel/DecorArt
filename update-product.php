<?php

    include "connection.php"; 
    
	$id_produto = $_GET['id'];
    $nome = $_POST['nome'];
	$tipo = $_POST['tipo'];
	$tema = $_POST['tema'];
	$altura = $_POST['altura'];
	$largura = $_POST['largura'];
	$preco = $_POST['preco'];
	$imagem = $_POST['imagem'];
	$estoque = $_POST['estoque'];
	$referencia = "produto";
	$link = $_POST['imagem'];
	
	$sql = "
		SELECT 
			imagem
		FROM
			produto
		WHERE
			id = {$id_produto}";
	$id_imagem = pg_fetch_array(pg_query($connection, $sql)); echo $sql;
	$id_imagem = $id_imagem[0];
	
	$sql = "	
		UPDATE 
			imagem
		SET
			link = '{$link}',
			referencia = '{$referencia}'
			where id = {$id_imagem};
	";
	pg_query($connection, $sql); echo $sql;
	
	$sql = "
		UPDATE 
			produto
		SET
			nome = '{$nome}',
			tipo = '{$tipo}',
			tema = '{$tema}',
			altura = {$altura},
			largura = {$largura},
			preco = {$preco},
			estoque = {$estoque}
		WHERE
			id = {$id_produto};
	";		  
	pg_query($connection, $sql); echo $sql;
	
    pg_close($connection);
	
    header("location:products.php");
	
?>