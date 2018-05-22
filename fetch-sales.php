<?php
	
	session_start();
	include "connection.php";
	if(!isset($_SESSION['last'])) { 
		$_SESSION['last'] = 0;
	}
	$whereString = $_SESSION['whereString'];
				
	include "connection.php";
	$sql_venda = "
		SELECT
			venda.id, venda.data_venda, venda.hora_venda, detalhes_usuario.nome, detalhes_usuario.sobrenome
		FROM
			venda
		LEFT OUTER JOIN
			detalhes_usuario
		ON
			detalhes_usuario.id = venda.usuario
		LEFT OUTER JOIN
			venda_item
		ON
			venda_item.id = venda.id
		LEFT OUTER JOIN
			produto
		ON
			produto.id = venda_item.produto
		".(isset($_SESSION['whereString']) ? " WHERE ".$_SESSION['whereString'] : "")."
		ORDER BY
			{$_SESSION['order_by']}, venda.id
		OFFSET
			{$_SESSION['last']}
	";
	$vendas = pg_query($connection, $sql_venda);
	
	$k = 0;
	for($x = 0; $x < pg_num_rows($vendas) && $k < 10; $x++) {
		
		$venda = pg_fetch_array($vendas);
		if($venda['id'] != $id) {
			$k++;
			$sql = "
				SELECT
					sum(produto.preco * venda_item.quantidade)
				FROM
					venda_item
				INNER JOIN
					produto
				ON
					produto.id = venda_item.produto
				WHERE
					venda_item.id = {$venda['id']};
			";
			$valor = pg_fetch_array(pg_query($connection, $sql));
			echo "
				<div id=\"sale_{$venda['id']}\" onClick=\"showDetails({$venda['id']});\">
					<div class=\"id\">
						{$venda['id']}
					</div>
					<div class=\"data\">
						{$venda['data_venda']}
					</div>
					<div class=\"hora\">
						{$venda['hora_venda']}
					</div>
					<div class=\"usuario\">
						{$venda['nome']} {$venda['sobrenome']}
					</div>
					<div class=\"valor_total\">
						{$valor[0]}
					</div>
				</div>
			";
			
			$sql = "
				SELECT
					produto.nome, produto.preco, venda_item.quantidade, produto.preco * venda_item.quantidade AS preco_parc
				FROM
					venda_item
				INNER JOIN
					produto
				ON
					produto.id = venda_item.produto
				WHERE
					venda_item.id = {$venda['id']}
			";
			echo '
				<div class="details" id="'.$venda['id'].'">
					<div class="title">
						<div class="produto">
							Produto
						</div>
						<div class="preco_unitario">
							Preço unitário
						</div>
						<div class="quantidade">
							Quantidade
						</div>
						<div class="preco_parcial">
							Preço parcial
						</div>
					</div>
			';
			$venda_itens = pg_query($connection, $sql);
			for($y = 0; $y < pg_num_rows($venda_itens); $y++) {
				
				$venda_item = pg_fetch_array($venda_itens);
				echo "
					<div onClick=\"showDetails()\">
						<div class=\"produto\">
							{$venda_item['nome']}
						</div>
						<div class=\"preco_unitario\">
							{$venda_item['preco']}
						</div>
						<div class=\"quantidade\">
							{$venda_item['quantidade']}
						</div>
						<div class=\"preco_parcial\">
							{$venda_item['preco_parc']}
						</div>
					</div>
				";
				
			}
			
			echo '
					</div>
			';
		}
		$id = $venda['id'];
		
	}
	if(!$_SESSION['last']) {
		echo '
			<span class="notSelectable" id="load-more-users" onClick="loadMoreSales()">Carregar mais</span>
		';
	}
	$_SESSION['last'] += $x;
	if($k < 10) {
		echo '
			<script type="text/javascript">
				hideLoadMore("users");
			</script>
		';
	}
	
?>