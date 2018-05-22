<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
    	<meta charset="utf-8">
        <link rel="icon" type="image/png" href="http://i.imgur.com/dTlIc19.png">	<!-- Ícone -->
        <title>Decorart LTDA</title>
        <!-- CSS -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.css">							<!-- Necessario para os ícones -->
        <!-- JavaScript -->
        <script type="text/javascript" src="js/jquery.min.js"></script>				<!-- Biblioteca do JavaScript "Write less, do more" -->
        <script type="text/javascript" src="js/tab-view.js"></script>				<!-- Código para a tab view -->
        <script type="text/javascript" src="js/jquery.mask.js"></script>			<!-- Plugin para a máscara do input -->
        <script type="text/javascript" src="js/main.js"></script>					<!-- Contém as principais funções -->
    </head>
    <body>
		
        <header class="user-background notSelectable">
        	&nbsp;
        </header>
        
        <div class="main">
        
        	<header class="notSelectable">
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
                        	if($_SESSION['acess'] == 'adm')
								echo '<a href="index.php"><span id="adm">ADM&nbsp;</span></a>';
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
            
            <a href="new-account.php"><span class="fa fa-plus-circle right-align">&nbsp;Novo usuario</span></a> <br>
            <table width="100%" cellpadding="5px" id="users" style="padding-bottom: 50px">
                <tr class="title">
                    <td width="5%">
                        <span onclick="location.href='?order_by=id'">Id</span>
						<?php
							if(!isset($_GET['order_by'])) {
								$_GET['order_by'] = "id";
							}
							if(substr_count($_GET['order_by'], "id") || !isset($_GET['order_by'])) {
								echo substr_count($_GET['order_by'], "DESC")
									? '<span class="fa fa-caret-square-o-down" onclick="location.href=\'?order_by=id\'"></span>'
									: '<span class="fa fa-caret-square-o-up" onclick="location.href=\'?order_by=id DESC\'"></span>';
							}
						?>
                    </td>
                    <td width="30%">
                        <span onclick="location.href='?order_by=email'">Email</span>
						<?php
							if(substr_count($_GET['order_by'], "email")) {
								echo substr_count($_GET['order_by'], "DESC")
									? '<span class="fa fa-caret-square-o-down" onclick="location.href=\'?order_by=email\'"></span>'
									: '<span class="fa fa-caret-square-o-up" onclick="location.href=\'?order_by=email DESC\'"></span>';
							}
						?>
                    </td>
                    <td width="20%">
                        <span onclick="location.href='?order_by=nome'">Nome</span>
						<?php
							if(substr_count($_GET['order_by'], "nome") && !substr_count($_GET['order_by'], "sobrenome")) {
								echo substr_count($_GET['order_by'], "DESC")
									? '<span class="fa fa-caret-square-o-down" onclick="location.href=\'?order_by=nome\'"></span>'
									: '<span class="fa fa-caret-square-o-up" onclick="location.href=\'?order_by=nome DESC\'"></span>';
							}
						?>
                    </td>
                    <td width="20%">
                        <span onclick="location.href='?order_by=sobrenome'">Sobrenome</span>
						<?php
							if(substr_count($_GET['order_by'], "sobrenome")) {
								echo substr_count($_GET['order_by'], "DESC")
									? '<span class="fa fa-caret-square-o-down" onclick="location.href=\'?order_by=sobrenome\'"></span>'
									: '<span class="fa fa-caret-square-o-up" onclick="location.href=\'?order_by=sobrenome DESC\'"></span>';
							}
						?>
                    </td>
                    <td width="15%">
                        Acesso
                    </td>
                    <td width="5%">
                        Editar
                    </td>
                    <td width="5%">
                        Excluir
                    </td>
                </tr>
                <tr>
                	<form method="get" id="frm-filter">
                        <td>
                            <input type="number" name="id" value="<?php echo $_GET['id'] ?>">
                        </td>
                        <td>
                            <input type="email" name="email" value="<?php echo $_GET['email'] ?>">
                        </td>
                        <td>
                            <input type="text" name="name" value="<?php echo $_GET['name'] ?>">
                        </td>
                        <td>
                            <input type="text" name="last_name" value="<?php echo $_GET['last_name'] ?>">
                        </td>
                        <td>
                        </td>
                        <td>
                        	<span class="fa fa-filter" onClick="document.getElementById('frm-filter').submit();"></span>
                        </td>
                        <td>
                            <span class="fa fa-eraser" onClick="document.getElementById('frm-filter').reset();"></span>
                        </td>
                    </form>
                </tr>
                <?php
				
					unset($_SESSION['whereString']);
					parse_str($_SERVER['QUERY_STRING'], $url);
					$url['email'] = strtolower($url['email']);
					$url['name'] = strtolower($url['name']);
					$url['last_name'] = strtolower($url['last_name']);
					if(!empty($url['id'])) {
						$whereString .= "
							detalhes_usuario.id = {$url['id']}
						";
					}
					if(!empty($url['email'])) {
						if(isset($whereString)) {
							$whereString .= "
								AND
							";
						}
						$whereString .= "
							to_tsvector(lower(conta_usuario.email)) @@ to_tsquery('{$url['email']}')
							OR
								lower(conta_usuario.email) LIKE '%{$url['email']}%'
						";
					}
					if(!empty($url['name'])) {
						if(isset($whereString)) {
							$whereString .= "
								AND
							";
						}
						$whereString .= "
							to_tsvector(lower(detalhes_usuario.nome)) @@ to_tsquery('{$url['name']}')
							OR
								lower(detalhes_usuario.nome) LIKE '%{$url['name']}%'
						";
					}
					if(!empty($url['last_name'])) {
						if(isset($whereString)) {
							$whereString .= "
								AND
							";
						}
						$whereString .= "
							to_tsvector(lower(detalhes_usuario.last_name)) @@ to_tsquery('{$url['last_name']}')
							OR
								lower(detalhes_usuario.last_name) LIKE '%{$url['last_name']}%'
						";
					}
					
					$_SESSION['whereString'] = $whereString;
					if(isset($_GET['order_by'])) {
						$_SESSION['order_by'] = $_GET['order_by'];
					}
					else {
						unset($_SESSION['order_by']);
					}
					unset($_SESSION['last']);
					include "fetch-users.php";
                
                ?>
            </table>
            
           <nav id="menu-footer">
                <span class="menu-item">
                    <a href="sell.php">Vender</a>
                </span>
                <span class="menu-item">
                	<a href="user.php">Usuários</a>
                </span>
                <span class="menu-item">
                	<a href="products.php">Produtos</a>
                </span>
                <span class="menu-item">
                	<a href="sales.php">Vendas</a>
                </span>
                <span class="menu-item">
                	<a href="statistics.php">Estatísticas</a>
                </span>
            </nav>
 
            <div class="footer">
            	<div id="copyright">&copy;&nbsp;2016 BeGaHMays Ltda</div>
                <div id="names">
					<h2>Desenvolvedores</h2>
                	07&nbspBrenda Thaynne	
					09&nbspGabrielSlompo		
					10&nbspGabriela Costa		
					26&nbspMaykon Michel		
					31&nbspVitor Manzatto
                </div>
                <div class="map">
                    <h3> Páginas Principais </h3>
                    <a href="index.php">Home</a><br>
                    <a href="shop.php">Loja</a><br>
                    <a href="cart.php">Carrinho</a><br>
                    <a href="feedback.php">Feedback</a><br>
                    <a href="about.php">Sobre</a><br>
                </div>
				<div class="map">
                    <h3> Links WIN-SCP </h3>
                    <a href="http://200.145.153.175/brendamatos/decorart/" target="_blank">WinSCP-Brenda</a><br>
					<a href="http://200.145.153.175/gabrielslompo/projeto/" target="_blank">WinSCP-Gabriel</a><br>
					<a href="http://200.145.153.175/gabrielanogueira/decorart/" target="_blank">WinSCP-Gabriela</a><br>
					<a href="http://200.145.153.175/maykonpalma/begahmays/decorart/" target="_blank">WinSCP-Maykon</a><br>
					<a href="http://200.145.153.175/vitormanzatto/DecorArt/" target="_blank">WinSCP-Vitor</a><br>
				</div>
                <div class="map">
                    <h3> Conta </h3>
                    <a href="signup-login.php?login">Login</a><br>
                    <a href="signup-login.php?signup">Cadastro</a><br>
                    <a href="my-account.php">Minha Conta</a><br>
					<a href="https://goo.gl/qfTGvu" target="_blank">Dropbox</a><br>
					<a href="https://goo.gl/lMgsBI" target="_blank">Drive</a><br>
                </div>	
                <div class="map">
                    <h3> Links ADM</h3>
                    <a href="https://goo.gl/vcZsBX" target="_blank">Formulário</a><br>
                    <a href="http://200.145.153.175/phppgadmin/" target="_blank">PhpPgAdmin</a><br>
                    <a href="http://imgur.com/" target="_blank">Imgur</a><br>
                    <a href="https://bitly.com/" target="_blank">Encurtar URL</a><br>
                    <a href="https://goo.gl/h02r5L" target="_blank">Blog Ariane Scarelli</a><br>
				</div>
            </div>
        </div>
        
        <div id="menu-footer-background">
        	&nbsp;
        </div>
        <div id="map-background">
        </div>
        <footer>
           	&nbsp;
        </footer>
        <a href="#" class="back-to-top"><span class="fa fa-arrow-circle-up fa-2x"></span></a>
        
    </body>
</html>