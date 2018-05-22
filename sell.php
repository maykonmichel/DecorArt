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
                    	<span class="menu-item" id="selected">Vender</span>
                    </a>
                    <a href="user.php">
                    	<span class="menu-item">Usuários</span>
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
                     
            <table width='100%'>
                <tr class="title">
                    <td width="5%">
                    	Id
                    </td>
                    <td width="40%">
                        Nome
                    </td>
                    <td width="15%">
                        Preço unitário
                    </td>
                    <td width="15%">
                        Quantidade
                    </td>
                    <td width="15%">
                        Preço parcial
                    </td>
                    <td width="10%">
                        Excluir
                    </td>
                </tr>
                <tr>
                	<form action="add-to-cart.php" method="get" id="frm-new-sell">
                        <td>
                            <input type="number" name="id" class="products" step="1" min="0">
                        </td>
                        <td>
                        </td>
                        <td>
                        </td>
                        <td>
                        	<input type="number" name="amount" class="products" step="1" min="0">
                        </td>
                        <td>
                        </td>
                        <td>
                        	<span class="fa fa-plus-circle" onClick="document.getElementById('frm-new-sell').submit();"></span>
                            &nbsp;&nbsp;&nbsp;
                        	<span class="fa fa-eraser" onClick="document.getElementById('frm-new-sell').reset();"></span>
                        </td>
                        <input type="submit" style="display:none">
                    </form>
                </tr>
                <?php
					
					for($k = 0; $k < count($products); $k++) {
						echo "
							<tr>
								<td>
									<a href=\"product.php?id_produto={$products[$k]['id']}\">
										<img src=\"{$products[$k]['image']}\" alt=\"\" height=\"150\">
									</a>
								</td>
								<td>
									<a href=\"product.php?id_produto={$products[$k]['id']}\">
										{$products[$k]['name']}
									</a>
								</td>
								<td>
									{$products[$k]['price_unit']}
								</td>
								<td>
									<a href=\"remove-from-cart.php?id={$products[$k]['id']}&amount\"><span class=\"fa fa-minus\"></span></a>
									&nbsp;&nbsp;{$products[$k]['amount']}&nbsp;&nbsp;
						";
						if($products[$k]['amount'] < $products[$k]['stock']) {
							echo "
								<a href=\"add-to-cart.php?id={$products[$k]['id']}&amount=1\"><span class=\"fa fa-plus\"></span></a>
							";
						}
						echo "	
								</td>
								<td>
									{$products[$k]['price_parc']}
								</td>
								<td>
									<a href=\"remove-from-cart.php?id={$products[$k]['id']}\">
										<span class=\"fa fa-trash fa-2x\"></span>
									</a>
								</td>
							</tr>
						";
					}
					
				?>
                <tr>
                	<td>
                    </td>
                	<td>
                    </td>
                	<td>
                    	<form action="new-client.php" method="post" id="frm-new-client">
                    		<input type="email" name="email" placeholder="Email*">
                        	<input type="submit" style="display:none">
                        </form>
                    </td>
                	<td>
                    	Preço total
                    </td>
                	<td>
                    	<?php echo $total; ?>
                    </td>
                	<td>
                    	<?php
						
							if(count(json_decode($_COOKIE['cart']))) {
                    			echo '<span class="buy-now" onClick="';
								echo "document.getElementById('frm-new-client')";
								echo '.submit();">Finalizar</span>';
							}
							
						?>
                    </td>
                </tr>
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
                	<a href="statistcs.php">Estatísticas</a>
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