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
                        	<sup>R$<strong><?php echo $total ?></strong>,00</sup>
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
            <?php 
	
				include "cart-class.php";	
			
				if(!isset($_SESSION['id'])) {
					header("location:signup-login.php?login");
				}
				
				if(isset($sold_out)) {
					header("location:sold-out.php");
				}
			
			?>	
            <div id="title">Qual o endereço de entrega?</div>
            <div id="confirm-address">
            	<form method="post" action="send-email.php" id="frm-signup">
                    <div class="category">
                        <h1>Endereço</h1>
                        <div class="field">
                            <label for="addresss"><span class="fa fa-road fa-2x left-align" title="Rua*"></span></label>
                                <input class="left-align" 
                                    type="text"
                                    id="address"
                                    name="address"
                                    title="Rua*"
                                    placeholder="Rua*"
                                    value="<?php echo $_SESSION['address']; ?>"
                                    required>
                            <label for="number"><span class="fa fa-home fa-2x right-align" title="Número*"></span></label>
                                <input class="right-align" 
                                    type="text"
                                    id="number"
                                    name="number"
                                    title="Número*"
                                    placeholder="Número*"
                                    value="<?php echo $_SESSION['number']; ?>"
                                    required>
                        </div>
                        <div class="field">
                            <label for="neighborhood"><span class="fa fa-map fa-2x left-align" title="Bairro*"></span></label>
                                <input class="left-align"
                                    type="text"
                                    id="neighborhood"
                                    name="neighborhood"
                                    title="Bairro*"
                                    placeholder="Bairro*"
                                    value="<?php echo $_SESSION['neighborhood']; ?>"
                                    required>
                            <label for="complement"><span class="fa fa-plus fa-2x right-align" title="Complemento"></span></label>
                                <input class="right-align"
                                    type="text"
                                    id="complement"
                                    name="complement"
                                    title="Complemento"
                                    placeholder="Complemento"
                                    value="<?php echo $_SESSION['complement']; ?>">
                        </div>
                        <div class="field">
                            <label for="city"><span class="fa fa-map-signs fa-2x left-align" title="Cidade*"></span></label>
                                <input class="left-align small"
                                    type="text"
                                    id="city"
                                    name="city"
                                    title="Cidade*"
                                    placeholder="Cidade*"
                                    value="<?php echo $_SESSION['city']; ?>"
                                    required>
                            <label for="state"><span class="fa fa-map-o fa-2x center-align" title="UF*" id="lblState"></span></label>
                                <input class="center-align small"
                                    type="text"
                                    id="state"
                                    name="state"
                                    pattern="[A-Za-z]{2}"
                                    title="U.F.*"
                                    onfocusout="validadeState()"
                                    onFocus="formatField('lblState', 'state', 'U.F.*')"
                                    placeholder="U.F.*"
                                    value="<?php echo $_SESSION['state']; ?>"
                                    required>
                            <label for="cep"><span class="fa fa-map-marker fa-2x right-align" title="C.E.P.*"></span></label>
                                <input class="right-align small"
                                    type="text"
                                    id="cep"
                                    name="cep"
                                    title="C.E.P.*"
                                    placeholder="C.E.P.*"
                                    value="<?php echo $_SESSION['cep']; ?>"
                                    required>
                        </div>
                    </div>
					<input type="submit" class="signup right-align" value="Usar este">
                </form>
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
        
        <div id="menu-footer-background">
        	&nbsp;
        </div>
        <footer>
           	&nbsp;
        </footer>
        <a href="#" class="back-to-top"><span class="fa fa-arrow-circle-up fa-2x"></span></a>
        
    </body>
</html>