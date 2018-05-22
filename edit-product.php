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
                    	<span class="menu-item" id="selected">Produtos</span>
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
				
				$id = $_GET['id_produto'];
				
				$sql = "
					SELECT
						produto.id,
						produto.nome,
						produto.tipo,
						produto.tema,
						produto.altura,
						produto.largura,
						produto.preco,
						imagem.link AS imagem,
						produto.estoque
					FROM
						produto
					INNER JOIN
						imagem
					ON
						produto.imagem = imagem.id
					WHERE
						produto.id = {$id}
				";
				
				$result = pg_query($connection, $sql);
				$product = pg_fetch_array($result);
				
			?>
            
            <img src="<?php echo $product['imagem']; ?>" alt="<?php echo $product['nome'] ?>" width="300px">
            <div class="product-details" id="<?php echo $product['id'] ?>">
            	<form action="update-product.php?id=<?php echo $product['id'] ?>" id="update-product" method="post">
                    <h1><input type="text" name="nome" value="<?php echo $product['nome'] ?>"></h1>
                    <h4>Nome</h4>
                    <h1>
                    	<select name="tipo">
                        	<option value="Chaveiro" label="Chaveiro"
								<?php if($product['tipo'] == "Chaveiro") echo "selected" ?>></option>
                        	<option value="Ímã de geladeira" label="Ímã de geladeira"
								<?php if($product['tipo'] == "Ímã de geladeira") echo "selected" ?>></option>
                        	<option value="Miniatura" label="Miniatura"
								<?php if($product['tipo'] == "Miniatura") echo "selected" ?>></option>
                        	<option value="Porta recado" label="Porta recado"
								<?php if($product['tipo'] == "Porta recado") echo "selected" ?>></option>
                        </select>
					</h1>
                    <h4>Tipo</h4>
                    <h1><input type="text" name="tema" value="<?php echo $product['tema'] ?>"></h1>
                    <h4>Tema</h4>
                    <h1><input type="number" name="altura" value="<?php echo $product['altura'] ?>">cm</h1>
                    <h4>Altura</h4>
                    <h1><input type="number" name="largura" value="<?php echo $product['largura'] ?>">cm</h1>
                    <h4>Largura</h4>
                    <h1>R$ <input type="number" name="preco"
                    	value="<?php echo str_replace("R$ ", "", str_replace(",", ".", $product['preco'])) ?>"></h1>
                    <h4>Preço</h4>
                    <h1><input type="text" name="imagem" value="<?php echo $product['imagem'] ?>"></h1>
                    <h4>Imagem</h4>
                    <h1><input type="number" name="estoque" value="<?php echo $product['estoque'] ?>"></h1>
                    <h4>Estoque</h4>
                    <input type="submit" style="display:none">
                </form>
            </div>
           <span id="sold-out" onClick="document.getElementById('update-product').submit();">Salvar</span>
            
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