<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="http://i.imgur.com/dTlIc19.png">  <!-- Ícone -->
        <title>Decorart LTDA</title>
        <!-- CSS -->
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/font-awesome.css">                           <!-- Necessario para os ícones -->
        <!-- JavaScript -->
        <script type="text/javascript" src="js/jquery.min.js"></script>             <!-- Biblioteca do JavaScript "Write less, do more" -->
        <script type="text/javascript" src="js/tab-view.js"></script>               <!-- Código para a tab view -->
        <script type="text/javascript" src="js/jquery.mask.js"></script>            <!-- Plugin para a máscara do input -->
        <script type="text/javascript" src="js/main.js"></script>                   <!-- Contém as principais funções -->
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
                            if($_SESSION['acesso'] == 'adm')
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
                        <span class="menu-item">Usuários</span>
                    </a>
                    <a href="products.php">
                        <span class="menu-item">Produtos</span>
                    </a>
                    <a href="sales.php">
                    	<span class="menu-item" id="selected">Vendas</span>
                    </a>
                    <a href="statistics.php">
                    	<span class="menu-item">Estatísticas</span>
                    </a>
                </nav>
            </header>
            
            <div class="sales">
            	<form id="frm-filter">
                	<table width="100%" cellpadding="15px">
                        <tr>
                            <td width="5%">
                            	<input type="number" name="id" placeholder="Id" min="1" step="1" value="<?php echo $_GET['id'] ?>">
                            </td>
                            <td width="12%">
                            	<input type="text"
                                	id="birthday"
                                    name="data"
                                    placeholder="Data da venda"
                                    value="<?php echo $_GET['data'] ?>"
                                    onfocusout="validateBirthday()"
                                >
                            </td>
                            <td width="12%"></td>
                            <td width="30%">
                            	<input type="text" name="produto" placeholder="Produto" value="<?php echo $_GET['produto'] ?>">
                            </td>
                            <td width="13%">
                            	<span class="fa fa-search" onClick="document.getElementById('frm-filter').submit()"> Filtrar</span>
                            	<br><span class="fa fa-times" onClick="location.href='sales.php'"> Limpar</span>
                            </td>
                        </tr>
                    </table>
                    <input type="submit" style="display:none">
                </form>
                <br>
            	<div class="title">
                    <div class="id" onclick="location.href='?order_by=id'">Id</div>
                    <?php
						if(substr_count($_GET['order_by'], "id") || !isset($_GET['order_by'])) {
							echo substr_count($_GET['order_by'], "DESC")
								? '<span class="fa fa-caret-square-o-down" onclick="location.href=\'?order_by=id\'"></span>'
								: '<span class="fa fa-caret-square-o-up" onclick="location.href=\'?order_by=id DESC\'"></span>';
						}
					?>
                    <div class="data" onclick="location.href='?order_by=data'">Data</div>
                    <?php
						if(substr_count($_GET['order_by'], "data")) {
							echo substr_count($_GET['order_by'], "DESC")
								? '<span class="fa fa-caret-square-o-down" onclick="location.href=\'?order_by=data\'"></span>'
								: '<span class="fa fa-caret-square-o-up" onclick="location.href=\'?order_by=data DESC\'"></span>';
						}
					?>
                    <div class="hora" onclick="location.href='?order_by=hora'">Hora</div>
                    <?php
						if(substr_count($_GET['order_by'], "hora")) {
							echo substr_count($_GET['order_by'], "DESC")
								? '<span class="fa fa-caret-square-o-down" onclick="location.href=\'?order_by=hora\'"></span>'
								: '<span class="fa fa-caret-square-o-up" onclick="location.href=\'?order_by=hora DESC\'"></span>';
						}
					?>
                    <div class="usuario" onclick="location.href='?order_by=usuario'">Usuário</div>
                    <?php
						if(substr_count($_GET['order_by'], "usuario")) {
							echo substr_count($_GET['order_by'], "DESC")
								? '<span class="fa fa-caret-square-o-down" onclick="location.href=\'?order_by=usuario\'"></span>'
								: '<span class="fa fa-caret-square-o-up" onclick="location.href=\'?order_by=usuario DESC\'"></span>';
						}
					?>
                    <div class="valor_total">Valor Total</div>
                </div>
                
                <?php
					
					unset($_SESSION['whereString']);
					unset($_SESSION['last']);
					if(!empty($_GET['id'])) {
						$whereString = "
							venda.id = {$_GET['id']}
						";
					}
					if(!empty($_GET['data'])) {
						if(isset($whereString)) {
							$whereString .= "
								AND
							";
						}
						$whereString .= "
							venda.data_venda = '{$_GET['data']}'
						";
					}
					if(!empty($_GET['produto'])) {
						if(isset($whereString)) {
							$whereString .= "
								AND
							";
						}
						$_GET['produto'] = strtolower($_GET['produto']);
						if (preg_match("/\s/", $_GET['produto'])) {
							$whereString = "
									to_tsvector(lower(produto.nome)) ||
									to_tsvector(lower(produto.tema)) ||
									to_tsvector(lower(produto.tipo))
										@@ plainto_tsquery('{$_GET['produto']}')
							";
									
						}
						else {
							$whereString = "
									to_tsvector(lower(produto.nome)) ||
									to_tsvector(lower(produto.tema)) ||
									to_tsvector(lower(produto.tipo))
										@@ to_tsquery('{$_GET['produto']}')
							";
									
						}
						$whereString .= "
							OR
								lower(produto.nome) ||
								lower(produto.tema) ||
								lower(produto.tipo)
								LIKE '%{$_GET['produto']}%'
						";
					}
					if($_GET['order_by'] == "data") {
						$_SESSION['order_by'] = "venda.data_venda";
					}
					else if($_GET['order_by'] == "hora") {
						$_SESSION['order_by'] = "venda.hora_venda";
					}
					else if($_GET['order_by'] == "usuario") {
						$_SESSION['order_by'] = "detalhes_usuario.nome";
					}
					else {
						$_SESSION['order_by'] = "venda.id";
					}
					if(substr_count($_GET['order_by'], "DESC")) {
						$_SESSION['order_by'] .= " DESC";
					}
					$_SESSION['whereString'] = $whereString;
                	include "fetch-sales.php";
					
				?>
            </div>
             
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