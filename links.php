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
                    	<span class="menu-item">Usuários</span>
                    </a>
                    <a href="products.php">
                    	<span class="menu-item">Produtos</span>
                    </a>
                    <a href="statistics.php">
                    	<span class="menu-item">Estatísticas</span>
                    </a>
                    <a href="links.php">
                    	<span class="menu-item" id="selected">Links</span>
                    </a>
                </nav>
            </header>
                     
            <div class="category">
            	<a href="https://goo.gl/qfTGvu" target="_blank"><h2>Dropbox</h2></a>
                <a href="https://goo.gl/vcZsBX" target="_blank"><h2>Formulário</h2></a>
				<a href="http://200.145.153.175/phppgadmin/" target="_blank"><h2>PhpPgAdmin</h2></a>
				<a href="http://imgur.com/" target="_blank"><h2>Imgur</h2></a>
				<a href="https://bitly.com/" target="_blank"><h2>Encurtar URL</h2></a>
				<a href="https://goo.gl/h02r5L" target="_blank"><h2>Blog Ariane Scarelli</h2></a>
				<a href="https://goo.gl/lMgsBI" target="_blank"><h2>Drive</h2></a>
				<a href="http://200.145.153.175/brendamatos/decorart/" target="_blank"><h2>WinSCP-Brenda</h2></a>
				<a href="http://200.145.153.175/gabrielslompo/projeto/" target="_blank"><h2>WinSCP-Gabriel</h2></a>
				<a href="http://200.145.153.175/gabrielanogueira/decorart/" target="_blank"><h2>WinSCP-Gabriela</h2></a>
				<a href="http://200.145.153.175/maykonpalma/begahmays/decorart/" target="_blank"><h2>WinSCP-Maykon</h2></a>
				<a href="http://200.145.153.175/vitormanzatto/DecorArt/" target="_blank"><h2>WinSCP-Vitor</h2></a>
				
            </div>
            
             <nav id="menu-footer">
                <span class="menu-item">
                    <a href="index.php">Home</a>
                </span>
                <span class="menu-item">
                	<a href="shop.php">Loja</a>
                </span>
                <span class="menu-item">
                	<a href="cart.php">Carrinho</a>
                </span>
                <span class="menu-item">
                	<a href="feedback.php">Feedback</a>
                </span>
                <span class="menu-item">
                	<a href="about.php">Sobre</a>
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
                    <h3> Categorias dos Produtos </h3>
                    <a href="shop.php?tipo%5B0%5D=Imã+de+geladeira">Imã de geladeira</a><br>
                    <a href="shop.php?tipo%5B1%5D=Miniatura">Miniatura</a><br>
                    <a href="shop.php?tipo%5B0%5D=Porta+joia">Porta Joia</a><br>
                    <a href="shop.php?tipo%5B0%5D=Porta+Recado">Porta Recado</a><br>
                    <a href="shop.php?tipo%5B0%5D=Porta+retrato">Porta retrato</a><br>
				</div>
                <div class="map">
                    <h3> Conta </h3>
                    <a href="signup-login.php?login">Login</a><br>
                    <a href="signup-login.php?signup">Cadastro</a><br>
                    <a href="my-account.php">Minha Conta</a>
                </div>	
                <div class="map">
                    <h3> Sobre Biscuit </h3>
                    <a href="https://www.youtube.com/watch?v=SpYDNS-jumE">Video</a><br>
                    <a href="http://www.dicionarioinformal.com.br/biscuit/">Significado</a><br>
                    <a href="http://artesanato.culturamix.com/biscuit/a-historia-do-biscuit">História</a><br>
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