<?php

	include "connection.php";
	
	$cart = json_decode($_COOKIE['cart'], true);
	
	$total = 0;
	$count = 0;
	$id = 1;
	while($count < count($cart) && $id < 1000) {
		if(isset($cart[$id])) {
			$sql = "
				SELECT 
					produto.id,
					produto.nome,
					produto.tipo,
					produto.tema,
					produto.altura,
					produto.largura,
					produto.preco,
					imagem.link AS imagem,
					produto.estoque
				FROM
					produto
				INNER JOIN
					imagem
				ON
					produto.imagem = imagem.id
				WHERE
					produto.id = {$id}
			";
			
			$result = pg_query($connection, $sql);
			$product = pg_fetch_array($result);
			if($product['estoque'] < $cart[$id]) {
				$sold_out[$id] = true;
			}
			$product['preco'] = str_replace(",", ".", $product['preco']);
			$product['preco'] = str_replace("R$ ", "", $product['preco']);
			$total += $product['preco'] * $cart[$id];
			$products[$count] = array(
				'id' => $id,
				'name' => $product['nome'],
				'image' => $product['imagem'],
				'price_unit' => "R$ ".number_format($product['preco'], 2, ',', '.'),
				'amount' => $cart[$id],
				'price_parc' => "R$ ".number_format($product['preco'] * $cart[$id], 2, ',', '.'),
				'stock' => $product['estoque']
			);
			$count++;
		}
		$id++;
	}
	$total = "R$ ".number_format($total, 2, ',', '.');	
	
?>