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
        <script type="text/javascript" src="js/main.js"></script>					<!-- Contém as principais funções -->
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
                        	if($_SESSION['acess'] == 'adm')
								echo '<a href="sell.php"><span id="adm">ADM&nbsp;</span></a>';
							echo $_SESSION['name'];
						?>
                    </span>
                </nav>
                <a href="index.php" class="logo"></a>
                <nav class="menu-container">
                    <a href="index.php">
                    	<span class="menu-item">Home</span>
                    </a>
                    <a href="shop.php">
                    	<span class="menu-item">Loja</span>
                    </a>
                    <a href="cart.php">
                    	<span class="menu-item">Carrinho</span>
                    </a>
                    <a href="feedback.php">
                    	<span class="menu-item">Feedback</span>
                    </a>
                    <a href="about.php">
                    	<span class="menu-item">Sobre</span>
                    </a>
                </nav>
            </header>
            
            <div class="category" id="refresh">
            	<h1>Compra efetuada com sucesso!</h1>
                  <h2>Verifique o seu email</h2>
                  <a href="https://www.google.com/gmail/" target="_blank"><img src="http://imgur.com/7NBa9EC.png" alt="gmail" class="mail"></a>&nbsp;
                  <a href="https://www.hotmail.com/" target="_blank"><img src="http://i.imgur.com/kUI81Fd.png" alt="hotmail" class="mail"></a>&nbsp;
                  <a href="https://www.outlook.com/" target="_blank"><img src="http://i.imgur.com/rJDNMnr.png" alt="outlook" class="mail"></a>&nbsp;
                  <a href="https://mail.yahoo.com/" target="_blank"><img src="http://i.imgur.com/GnK73wb.png" alt="yahoo" class="mail"></a>&nbsp;
                  <a href="https://www.email.uol.com.br/" target="_blank"><img src="http://i.imgur.com/LgJvclR.png" alt="uol mail" class="mail"></a>
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
                    <a href="others.php">Outros</a><br>
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
        <footer>
           	&nbsp;
        </footer>
        <a href="#" class="back-to-top"><span class="fa fa-arrow-circle-up fa-2x"></span></a>
        
    </body>
</html>