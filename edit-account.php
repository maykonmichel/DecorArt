<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
    	<meta charset="utf-8">
        <link rel="icon" type="image/png" href="http://i.imgur.com/dTlIc19.png">	<!-- Ícone -->
        <title>BeGaHMay's</title>
        <!-- CSS -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.css">							<!-- Necessario para os ícones -->
        <!-- JavaScript -->
        <script type="text/javascript" src="js/jquery.min.js"></script>				<!-- Biblioteca do JavaScript "Write less, do more" -->
        <script type="text/javascript" src="js/main.js"></script>					<!-- Contém as principais funções -->
        <script type="text/javascript" src="js/tab-view.js"></script>				<!-- Código para a tab view -->
        <script type="text/javascript" src="js/jquery.mask.js"></script>			<!-- Plugin para a máscara do input -->
    </head>
    <body>
        	
        <header class="user-background">
        	&nbsp;
        </header>
        
        <div class="main">
        
        	<header>
            	<nav class="user">
                	<a href="<?php if(isset($_SESSION['id'])) echo "my-account.php"; else echo "signup-login.php?login"; ?>">
                        <span class="fa fa-user"></span>&nbsp;&nbsp;<?php if(isset($_SESSION['id'])) echo "Minha conta"; else echo "Entrar"; ?>
                    </a>
                    <a href="cart.php">
                        <span class="fa fa-shopping-cart"></span>&nbsp;&nbsp;Carrinho&nbsp;
                        	<sup><strong><?php include "cart-class.php"; echo $total ?></strong></sup>
                    </a>
                    <a href="<?php if(isset($_SESSION['id'])) echo "logout.php"; else echo "signup-login.php?signup"; ?>">
                        <span class="fa fa-user-<?php if(isset($_SESSION['id'])) echo "times"; else echo "plus"; ?>"></span>&nbsp;
						<?php if(isset($_SESSION['id'])) echo "Sair"; else echo "Inscrever-se"; ?>
                    </a>
                    <span id="wellcome">Bem-vindo&nbsp;
						<?php
							if(!isset($_SESSION['id']))
								echo "visitante";
                        	if($_SESSION['acesso'] == 'adm')
								echo '<span id="adm">ADM&nbsp;</span>';
							echo $_SESSION['name'];
						?>
                    </span>
                </nav>
                <a href="index.php" class="logo"></a>
                <nav class="menu-container">
                    <a href="sell.php">
                    	<span class="menu-item">Vender</span>
                    </a>
                    <a href="user.php">
                    	<span class="menu-item" id="selected">Usuários</span>
                    </a>
                    <a href="products.php">
                    	<span class="menu-item">Produtos</span>
                    </a>
                    <a href="sales.php">
                    	<span class="menu-item">Vendas</span>
                    </a>
                    <a href="statistics.php">
                    	<span class="menu-item">Estatísticas</span>
                    </a>
                </nav>
            </header>
            
            <?php
			
				include "connection.php";
				$sql = "
					 SELECT
						conta_usuario.*,
						detalhes_usuario.*,
						endereco.*
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
					WHERE
						conta_usuario.id = {$_GET['id']}
				";
				$user = pg_fetch_array(pg_query($connection, $sql));
				$user['data_nasc'] = date("d-m-Y", strtotime($user['data_nasc']));
			
			?>
            
            <div id="title">Editar conta</div>
            <div id="my-account">
            	<form method="post" action="update-account.php" id="frm-signup">
                	<input type="number" name="id" id="id" value="<?php echo $user[0] ?>" style="display:none">
                	