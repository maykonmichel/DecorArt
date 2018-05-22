<?php

	function commonFilterString($filter)
	{
		parse_str($_SERVER['QUERY_STRING'], $url);
		foreach($url[$filter] as $element)								//Para cada elemento do array filtro
		{																//Flag or: true quando mais de uma opção para um mesmo filtro
			if($flag_or) 												//Se a flag or = true
				$whereString .= " OR ";									//OR é adicionado na string sql
			else														//Se a flag or = false
			{															//Flag and: true quando mais de um filtro ativo
				$flag_or = true;										//Flag or setada para true
				if($flag_and) 											//Se flag and = true
					$whereString .= " AND ";							//AND é adicionado na string sql
			}
			$whereString .= $filter." = '".$element."'";				//"filtro" = "elemento" colocado na string sql
			$flag_and = true;
		}
	}

	function urlFilter($filter, $value, $value2 = 0) {
		parse_str($_SERVER['QUERY_STRING'], $url);
		if(!$value2) {
			if(in_array($value, $url[$filter])) {
				unset($url[$filter][array_search($value, $url[$filter])]);
			}
			else {
				$url[$filter][] = $value;
			}
		}
		else {
			if(in_array($value, $url[$filter])) {
				unset($url[$filter]);
			}
			else {
				$url[$filter]["min"] = $value;
				$url[$filter]["max"] = $value2;
			}
		}
		return("?".http_build_query($url));
	}
	
	function filterChecked($filter, $value, $value2 = 0) {
		parse_str($_SERVER['QUERY_STRING'], $url);
		if(!$value2 && in_array($value, $url[$filter]) ||
			$url[$filter]['min'] == $value && $url[$filter]['max'] == $value2) {
			return "checked";
		}
	}
	
	function commonFilter($filter, $title) {
		include "connection.php";
		
		if($filter == "largura" || $filter == "altura")
			$unit = "cm";
		
		$sql = "
			SELECT
				{$filter}, COUNT({$filter})
			FROM
				produto
			".(isset($_SESSION['whereString']) ? " WHERE " : "")."{$_SESSION['whereString']}
			GROUP BY
				{$filter}
			ORDER BY
				{$filter}
		";
		$result = pg_query($connection, $sql);
		$num_rows = pg_num_rows($result);
		
		echo "
			<div class=\"filter\">
				<h3>{$title}</h3>
				<ul>
		";
		for($k = 0; $k < $num_rows; $k++) {
			$row_filter = pg_fetch_array($result);
			echo "
				<li>
					<input type=\"checkbox\"
							onchange=\"window.location.href='".urlFilter($filter, $row_filter[$filter])."'\"
							id=\"{$filter}{$row_filter[0]}\"
							".filterChecked($filter, $row_filter[$filter]).">
					<label for=\"{$filter}{$row_filter[0]}\">
						{$row_filter[0]}{$unit} ({$row_filter[1]})
					</label>
				</li>
			";
		}
		echo "
			</ul>
		</div>
		";
	}
	
	parse_str($_SERVER['QUERY_STRING'], $url);
	$search = $url['search'];
	$whereString = "";
	if(isset($url['order_by'])) {
		$_SESSION['order_by'] = $url['order_by'];
		unset($url['order_by']);
	}
	if(isset($url['min'])) {
		$min = $url['min'];
		$max = $url['max'];
		unset($url['min']);
		unset($url['max']);
	}
	else {
		$sql .= "
			SELECT
				MIN(preco), MAX(preco)
			FROM
				produto
		";
		$result = pg_fetch_array(pg_query($connection, $sql));
		$min = str_replace(",", ".", str_replace("R$ ", "", $result[0]));
		$max = str_replace(",", ".", str_replace("R$ ", "", $result[1]));
	}
	$whereString = "
		preco >= '".str_replace(".", ",", $min)."' AND preco <= '".str_replace(".", ",", $max)."'
	";
	if(!empty($url)) {
		$whereString .= "
			AND
		";
	}
	if(isset($search)) {
		if (preg_match("/\s/", $search)) {
			$whereString = "
					to_tsvector(lower(produto.nome)) ||
					to_tsvector(lower(produto.tema)) ||
					to_tsvector(lower(produto.tipo))
						@@ plainto_tsquery('{$search}')
			";
					
		}
		else {
			$whereString = "
					to_tsvector(lower(produto.nome)) ||
					to_tsvector(lower(produto.tema)) ||
					to_tsvector(lower(produto.tipo))
						@@ to_tsquery('{$search}')
			";
					
		}
		$whereString .= "
			OR
				lower(produto.nome) ||
				lower(produto.tema) ||
				lower(produto.tipo)
				LIKE '%{$search}%'
		";
		if(is_numeric($url['search'])) {
			$whereString = "
				produto.id = {$search}
			";
		}
		unset($url['search']);
		if(!empty($url)) {
			$whereString .= "
				AND
			";
		}
	}
	$x = 0;
	foreach($url as $filter) {
		$x++;
		for($y = 0; $y < count($filter); $y++) {
			$option = $filter[$y];
			$whereString .= array_search($filter, $url)."='".$option."'";
			if($y+1 < count($filter)) {
				$whereString .= " OR ";
			}
		}
		if($x+1 <= count($url)) {
			$whereString .= " AND ";
		}
	}
	if(empty($whereString)) {
		unset($_SESSION['whereString']);
	}
	else {
		$_SESSION['whereString'] = $whereString;
	}

?>