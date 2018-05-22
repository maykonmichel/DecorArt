<?php

	session_start();
	include "connection.php";
	if(isset($_SESSION['last'])) { 
		$_SESSION['last'] += 10;
	}
	else {
		$_SESSION['last'] = 0;
	}
	if(!isset($_SESSION['order_by'])) {
		$_SESSION['order_by'] = "id";
	}
	$whereString = $_SESSION['whereString'];

	$sql = "
		SELECT
			*
		FROM
			conta_usuario
		FULL OUTER JOIN
			detalhes_usuario
		ON
			detalhes_usuario.id = conta_usuario.id
		FULL OUTER JOIN
			endereco
		ON
			endereco.usuario = conta_usuario.id
		".(isset($whereString) ? "WHERE ".$whereString : "")."
		ORDER BY
			".(substr_count($_SESSION['order_by'], "nome") ? "detalhes_usuario." : "conta_usuario.").$_SESSION['order_by'].",
			conta_usuario.id
		OFFSET
			{$_SESSION['last']}
		LIMIT
			11
	";
	
	$result = pg_query($connection, $sql);
	for($k = 0; $k < pg_num_rows($result) && $k < 10; $k++) {
		$users = pg_fetch_array($result);
		echo '
			<tr>
				<td>
		';
		echo $users[0];
		echo '
			</td>
			<td style="text-align:left; padding-left:15px">
		';						
		echo $users['email'];
		echo '
			</td>
			<td style="text-align:left; padding-left:15px">
		';
		echo $users['nome'];
		echo '
			</td>
			<td style="text-align:left; padding-left:15px">
		';
		echo $users['sobrenome'];
		echo '
			</td>
			<td>
		';
		echo $users['acesso'];
		echo '
			</td>
			<td>
				<a href="edit-account.php?id='.$users[0].'"><span class="fa fa-edit"></span></a>
			</td>
			<td>
		';
		if($users[4]) {
			echo '
				<a href="reactivate-account.php?id='.$users[0].'"><span class="fa fa-toggle-off"></span></a>
			';
		}
		else {
			echo '
				<a href="delete-account.php?id='.$users[0].'"><span class="fa fa-toggle-on"></span></a>
			';
		}
		echo '  	
			</td>
			</tr>
		';
	}
	if(!$_SESSION['last']) {
		echo '
			<span class="notSelectable" id="load-more-users" onClick="loadMoreUsers()">Carregar mais</span>
		';
	}
	if(pg_num_rows($result) <= 10) {
		echo '
			<script type="text/javascript">
				hideLoadMore("users");
			</script>
		';
	}

?>