<?php

	session_start();
	include "connection.php";
	if(isset($_SESSION['last'])) { 
		$_SESSION['last'] += 9;
	}
	else {
		$_SESSION['last'] = 0;
	}
	$whereString = $_SESSION['whereString'];
	
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
		".(isset($_SESSION['whereString']) ? " WHERE ".$_SESSION['whereString'] : "")."
		ORDER BY
			".(isset($_SESSION['order_by']) ? $_SESSION['order_by'] : "id").", id
		OFFSET
			{$_SESSION['last']}
		LIMIT 
			10
	";
	$result = pg_query($connection, $sql);
	$num_rows = pg_num_rows($result);
	
	$php_self = strpos($_SERVER['PHP_SELF'], "shop") ? "product" : "edit-product";
	for($k = 0; $k < $num_rows && $k < 9; $k++) {
		$product = pg_fetch_array($result);
		echo '
			<div class="product" id="'.$product['id'].'">
				<div class="image">
					<a href="'.$php_self.'.php?id_produto='.$product['id'].'">
						<img src="'.$product['imagem'].'" title="'.$product['nome'].'" />
					</a>
				</div>
				<a href="'.$php_self.'.php?id_produto='.$product['id'].'">
					'.$product['nome'].'
				</a>
				<h1>
					<a href="'.$php_self.'.php?id_produto='.$product['id'].'">
						'.$product['preco'].'
					</a>
				</h1>
				<a href="'.$php_self.'.php?id_produto='.$product['id'].'">
					<span class="buy-now">'.($php_self == "product" ? "Comprar" : "Editar").'</span>
				</a>
			</div>
		';
	}
	if(!$_SESSION['last']) {
		echo '
			<span class="notSelectable" id="load-more-products" onClick="loadMoreProducts()">Carregar mais</span>
		';
	}
	if($num_rows <= 9) {
		echo '
			<script type="text/javascript">
				hideLoadMore("products");
			</script>
		';
	}
	
?>