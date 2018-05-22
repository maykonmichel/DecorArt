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
            
            <div id="tabCtrl">
                <nav>
                    <a href="?signup" id="tab-signup">Inscrever-se</a>
                    <a href="?login" id="tab-login">Entrar</a>
                </nav>
                <div id="tabs">
                    <div id="signup">
                    	<form method="post" action="signup.php" id="frm-signup">
                        	<div class="category">
                            	<h1>Detalhes da conta</h1> 
                                <div class="field">
                                	<label for="email"><span class="fa fa-envelope-o fa-2x left-align" title="Email*"></span></label>
                                        <input class="left-align"
                                        	type="email"
                                            name="email"
                                            id="email"
                                            placeholder="Email*"
                                            title="Email*"
                                            onKeyUp="txtToLowerCase('email')"
                                           	pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                            onfocusout="validateEmail()"
                                            required>
                                    <label for="confirm-email"><span class="fa fa-envelope-o fa-2x right-align" id="lblCEmail" title="Confirmar email*"></span></label>
                                        <input class="right-align"
                                        	type="email"
                                            name="confirm-email"
                                            id="confirm-email"
                                            placeholder="Confirmar email*"
                                            title="Confirmar email*"
                                            onKeyUp="txtToLowerCase('confirm-email')"
                                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                            onfocusout="validateEmail()"
                                            onFocus="formatField('lblCEmail', 'confirm-email', 'Confirmar email*')"
                                            required> 
                                </div>  
                                <div class="field">
                                    <label for="password"><span class="fa fa-lock fa-2x left-align" id="lblPw" title="Senha*"></span></label>
                                        <input class="left-align"
                                        	type="password"
                                            name="password"
                                            id="password"
                                            placeholder="Senha*"
                                            title="Senha*"
                                            onKeyPress="securePass()"
                                            onFocus="formatField('lblBirthday', 'birthday', 'Data de nascimento*')"
                                            maxlength="16"
                                            required>
                                    <label for="confirm-password"><span class="fa fa-lock fa-2x right-align" id="lblCpw" title="Confirmar senha*"></span></label>
                                        <input class="right-align"
                                        	type="password"
                                            name="confirm-password"
                                            id="confirm-password"
                                            placeholder="Confirmar senha*"
                                            title="Confirmar senha*"
                                            onFocus="formatField('lblCpw', 'confirm-password', 'Confirmar senha*')"
                                            onfocusout="validatePassword()"
                                            maxlength="16"
                                            required> 
                                </div>
                            </div>
                            <div class="category">
                            	<h1>Detalhes pessoais</h1> 
                                <div class="field">
                                	<label for="name"><span class="fa fa-user fa-2x left-align" title="Nome*"></span></label>
                                        <input class="left-align"
                                        	type="text"
                                            name="name"
                                            id="name"
                                            placeholder="Nome*"
                                            pattern="[a-zA-Z]+"
                                            title="Nome*"
                                            required>
                                    <label for="last_name"><span class="fa fa-user fa-2x right-align" title="Sobrenome*"></span></label>
                                        <input class="right-align"
                                        	type="text"
                                            name="last_name"
                                            id="last_name"
                                            placeholder="Sobrenome*"
                                            pattern="[a-zA-Z]+"
                                            title="Sobrenome*"
                                            required> 
                                </div>  
                                <div class="field">
                                	<label for="gender"><span class="fa fa-venus-mars fa-2x left-align" title="Gênero*"></span></label>
                                    	<div class="input-area left-align">
                                        	Gênero*
                                            <input type="radio" name="genre" id="m" value="m" required>
                                            	<label for="m">Masculino</label>
                                            <input type="radio" name="genre" id="f" value="f" required>
                                            	<label for="f">Feminino</label>
                                        </div>
                                    <label for="birthday"><span class="fa fa-birthday-cake fa-2x right-align" id="lblBirthday" title="Data de nascimento*"></span></label>
                                    	<input class="right-align"
                                        	type="text"
                                        	id="birthday"
                                        	name="birthday"
                                            pattern="\d{2}\/\d{2}\/\d{4}"
                                            title="Data de nascimento*"
                                            placeholder="Data de nascimento*"
                                            onfocusout="validateBirthday()"
                                            onFocus="formatField('lblBirthday', 'birthday', 'Data de nascimento*')"
                                            required>
                                </div>
                                <div class="field">
                                	<label for="rg"><span class="fa fa-credit-card fa-2x left-align" title="R.G.*"></span></label>
                                    	<input class="left-align"
                                        	type="text"
                                            id="rg"
                                            name="rg"
                                            pattern="[0-9]{2}.[0-9]{3}.[0-9]{3}-[0-9A-Za-z]{1}"
                                            title="R.G.*"
                                            placeholder="R.G.*"
                                            required>
                                	<label for="cpf"><span class="fa fa-credit-card fa-2x right-align" id="lblCPF" title="C.P.F.*"></span></label>
                                    	<input class="right-align"
                                        	type="text"
                                        	id="cpf"
                                        	name="cpf"
                                            pattern="[0-9]{3}.[0-9]{3}.[0-9]{3}/[0-9]{2}"
                                            title="C.P.F.*"
                                            placeholder="C.P.F.*"
											onfocusout="validateCPF()"
                                            onFocus="formatField('lblCPF', 'cpf', 'C.P.F.*')"
                                            required>
                                </div>
                                <div class="field">
                                	<label for="telephone"><span class="fa fa-phone fa-2x left-align" title="Telefone*"></span></label>
                                    	<input class="left-align"
                                        	type="text"
                                            id="telephone"
                                            name="telephone"
                                            pattern="\([0-9]{2}\) [0-9]{4}-[0-9]{4}$"
                                            title="Telefone*"
                                            placeholder="Telefone*"
                                            required>
                                	<label for="cellphone"><span class="fa-mobile fa fa-2x right-align" title="Celular"></span></label>
                                    	<input class="right-align"
                                        	type="text"
                                            id="cellphone"
                                            name="cellphone"
                                            pattern="\([0-9]{2}\) [0-9]{5}-[0-9]{4}$"
                                            title="Celular"
                                            placeholder="Celular">
                                </div>
                            </div>
                            <div class="category">
                            	<h1>Endereço</h1>
                                <div class="field">
                                	<label for="address"><span class="fa fa-road fa-2x left-align" title="Rua*"></span></label>
                                    	<input class="left-align" 
                                        	type="text"
                                            id="address"
                                            name="address"
                                            title="Rua*"
                                            placeholder="Rua*"
                                            required>
                                	<label for="number">
                                    	<span class="fa fa-home fa-2x left-align small-label" title="Número*"></span>
                                        </label>
                                    	<input class="left-align small" 
                                        	type="text"
                                            id="number"
                                            name="number"
                                            title="Número*"
                                            placeholder="Número*"
                                            required>
                                	<label for="number"><span class="fa fa-home fa-2x right-align" title="Quadra"></span></label>
                                    	<input class="right-align small" 
                                        	type="text"
                                            id="block"
                                            name="block"
                                            title="Quadra"
                                            placeholder="Quadra">
                                </div>
                                <div class="field">
                                	<label for="neighborhood"><span class="fa fa-map fa-2x left-align" title="Bairro*"></span></label>
                                    	<input class="left-align"
                                        	type="text"
                                            id="neighborhood"
                                            name="neighborhood"
                                            title="Bairro*"
                                            placeholder="Bairro*"
                                            required>
                                	<label for="complement"><span class="fa fa-plus fa-2x right-align" title="Complemento"></span></label>
                                    	<input class="right-align"
                                        	type="text"
                                            id="complement"
                                            name="complement"
                                            title="Complemento"
                                            placeholder="Complemento">
                                </div>
                                <div class="field">
                                	<label for="city"><span class="fa fa-map-signs fa-2x left-align" title="Cidade*"></span></label>
                                    	<input class="left-align"
                                        	type="text"
                                            id="city"
                                            name="city"
                                            title="Cidade*"
                                            placeholder="Cidade*"
                                            required>
                                	<label for="state"><span class="fa fa-map-o fa-2x left-align small-label" title="UF*" id="lblState"></span></label>
                                    	<input class="left-align small"
                                        	type="text"
                                            id="state"
                                            name="state"
                                            pattern="[A-Za-z]{2}"
                                            title="U.F.*"
											onfocusout="validadeState()"
                                            onFocus="formatField('lblState', 'state', 'U.F.*')"
                                            placeholder="U.F.*"
                                            required>
                                	<label for="cep"><span class="fa fa-map-marker fa-2x right-align" title="C.E.P.*"></span></label>
                                    	<input class="right-align small"
                                        	type="text"
                                            id="cep"
                                            name="cep"
                                            title="C.E.P.*"
                                            placeholder="C.E.P.*"
                                            required>
                                </div>
                            </div>
                            <input class="signup" type="submit" value="Inscrever">
                            <input type="reset" value="Limpar">
                        </form>
                    </div>
                    <div id="login">
                    	<form action="login.php" method="post">
                            <div class="category">
                                <h1>Login</h1>
                                <div class="field">
                                    <label for="email_login"><span class="fa fa-envelope-o fa-2x left-align" title="Email*"></span></label>
                                        <input class="left-align"
                                        	type="email"
                                            name="email_login"
                                            id="email_login"
                                            placeholder="Email*"
                                            onKeyUp="txtToLowerCase('email_login')"
                                           	pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"
                                            required>
                                </div>
                                <div class="field">
                                    <label for="password_login"><span class="fa fa-lock fa-2x left-align" title="Confirmar senha*"></span></label>
                                        <input class="left-align"
                                        	type="password"
                                            name="password_login"
                                            id="password_login"
                                            placeholder="Senha*"
                                            required> 
                                </div>
                            <?php if(isset($_SESSION['error'])) echo "errou seu puto"; unset($_SESSION['error']); ?>
                            <input class="login" type="submit" value="Entrar">
                            </div>
                       	</form>
                    </div>
                </div>
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
				<center>
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
				</center>
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