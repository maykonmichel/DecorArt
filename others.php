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
        <link rel="stylesheet" type="text/css" href="css/layout_large.css">
        <link rel="stylesheet" type="text/css" href="css/layout_medium.css" media="only screen and (min-width:501px) and (max-width:800px)">
        <link rel="stylesheet" type="text/css" href="css/layout_small.css" media="only screen and (min-width:50px) and (max-width:500px)">
        <!-- JavaScript -->
        <script type="text/javascript" src="js/jquery.min.js"></script>				<!-- Biblioteca do JavaScript "Write less, do more" -->
        <script type="text/javascript" src="js/jquery.cycle.all.js"></script>		<!-- Plugin do jquery necessário para criar o slider -->
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
                        	if($_SESSION['acesso'] == 'adm')
								echo '<span id="adm">ADM&nbsp;</span>';
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
                    <a href="">
                    	<span class="menu-item" id="selected">Feedback</span>
                    </a>
                    <a href="about.php">
                    	<span class="menu-item">Sobre</span>
                    </a>
                </nav>
            </header>
			<iframe src="https://docs.google.com/forms/d/e/1FAIpQLSeracYl8jfagG2ay4db4DyJJeg9ygIc3hoHLL2MO89rqo8-Pg/viewform?embedded=true"
            	width="100%"
                height="1165px"
                frameborder="0"
                marginheight="0"
                marginwidth="0">Carregando…</iframe>
            
            <nav id="menu-footer" class="notSelectable">
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
                	<a href="">Outros</a>
                </span>
                <span class="menu-item">
                	<a href="about.php">Sobre</a>
                </span>
            </nav>
            <div class="footer notSelectable">
            	<span id="copyright">&copy;&nbsp;2016 BeGaHMays Ltda</span>
                <div id="names">
                	<p>07&nbsp;Brenda Thaynne</p>
                	<p>09&nbsp;Gabriel Slompo</p>
                	<p>10&nbsp;Gabriela Costa</p>
                	<p>26&nbsp;Maykon Michel</p>
                	<p>31&nbsp;Vitor Manzatto</p>
                </div>
            </div>
            
        </div>
        
        <div class="notSelectable" id="menu-footer-background">
        	&nbsp;
        </div>
        <footer class="notSelectable">
           	&nbsp;
        </footer>
        <a href="#" class="back-to-top"><span class="fa fa-arrow-circle-up fa-2x"></span></a>
        
    </body>
</html>