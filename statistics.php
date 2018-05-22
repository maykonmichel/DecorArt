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
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
                    <a href="sales.php">
                    	<span class="menu-item">Vendas</span>
                    </a>
                    <a href="statistics.php">
                    	<span class="menu-item" id="selected">Estatísticas</span>
                    </a>
                </nav>
            </header>            
                      
            <div class="category">
            	<h2>Faturamento de vendas por período:</h2>
                <div id="dailyChart"></div>
              <script type="text/javascript">
				
					google.charts.load("current", {packages:["line", "corechart"]});
					google.charts.setOnLoadCallback(drawDailyChart);
					
					function drawDailyChart() {
						var data = new google.visualization.DataTable();
						data.addColumn('number', 'Hora');
						<?php
					
							include "connection.php";
							$sql = "
								SELECT
									data_venda
								FROM
									venda
								GROUP BY
									data_venda
								ORDER BY
									data_venda
							";
							$dates = pg_fetch_all(pg_query($connection, $sql));
							for($k = 0; $k < count($dates); $k++) {
								echo "
									data.addColumn('number', '".date("d-m-Y", strtotime($dates[$k]['data_venda']))."')
								";
							}
							
						?>
					
						<?php
						
							$sql = "
								SELECT
									venda.data_venda,
									EXTRACT(HOUR FROM venda.hora_venda) AS hora,
									SUM(venda_item.quantidade * produto.preco) AS preco_parcial
								FROM
									venda
								INNER JOIN
									venda_item
								ON
									venda_item.id = venda.id
								INNER JOIN
									produto
								ON
									produto.id = venda_item.produto
								GROUP BY
										hora, venda.data_venda
								ORDER BY
										hora, venda.data_venda
							";
							$data = pg_query($connection, $sql);
						
						?>
						data.addRows([
							<?php
								for($x = 0; $x < pg_num_rows($data); $x++) {
									$row = pg_fetch_array($data);
									echo "[{$row['hora']},";
									for($y = 0; $y < count($dates); $y++) { 
										if($row['data_venda'] == $dates[$y]['data_venda']) {
											echo str_replace(",", ".", str_replace("R$ ", "", $row['preco_parcial']));
											if($y+1 < count($dates)) {
												$row = pg_fetch_array($data);
												$x++;
											}
										}
										else {
											echo '0';
										}
										if($y+1 < count($dates)) {
											echo ',';
										}
									}
									echo "]";
									if($x+1 < pg_num_rows($data)) {
										echo ',';
									}
								}
							?>
						]);
					
						var options = {
							chart: {
								title: 'Relatório de vendas por hora',
								subtitle: 'R$/h'
							},
							width: 925,
							height: 525
						};
					
					  var chart = new google.charts.Line(document.getElementById('dailyChart'));
						
					
					  chart.draw(data, options);
					  
					}
				
                </script>
               
				<h2>Quantidade total de produtos vendidos: </h2>
                			<h3>
				<?php
						
		
					include "connection.php";
					$sql = "SELECT 
								SUM(quantidade) 
							FROM 
								venda_item
							INNER JOIN 
								produto
							ON 
								venda_item.produto = produto.id;";
									 
					$quantidade = pg_fetch_array(pg_query($connection, $sql));
					echo $quantidade[0];
									
				?>
				</h3></p>
				<br>
				
				<h2>Porcentagem de venda por tipo de produto:</h2>
                <div id="productsChart"></div>
                <script type="text/javascript">
					google.charts.setOnLoadCallback(drawProductsChart);
					function drawProductsChart() {
						var data = google.visualization.arrayToDataTable([
							['Tipo', 'Quantidade vendida'],
							<?php
							
								$sql = '
								
									SELECT
										produto.tipo, SUM(venda_item.quantidade)
									FROM
										venda
									INNER JOIN
										venda_item
									ON
										venda_item.id = venda.id
									INNER JOIN
										produto
									ON
										produto.id = venda_item.produto
									GROUP BY
										produto.tipo
								
								';
								$types = pg_query($connection, $sql);
								for($k = 0; $k < pg_num_rows($types); $k++) {
									$type = pg_fetch_array($types);
									echo "['".$type['tipo']."',".$type['sum']."]";
									if($k+1 < pg_num_rows($types)) {
										echo ',';
									}
								}
							
							?>
						]);
						var options = {
							is3D: true,
						  	width: 925,
							height: 525
						};
						var chart = new google.visualization.PieChart(document.getElementById('productsChart'));
						chart.draw(data, options);
					  }
                </script>
				<h2>Faturamento total das vendas:</h2>
				<h3>
					<?php
									
						$sql = "SELECT
									sum(produto.preco)
								FROM
									produto
								INNER JOIN
									venda_item
								ON
									venda_item.produto = produto.id
								INNER JOIN
									venda
								ON
									venda.id = venda_item.id;";
					
								$quantTotal = pg_fetch_array(pg_query($connection, $sql));
								echo  $quantTotal[0]; 
											
					?>
                </h3>
                
				<h2>Quantidade de produtos vendidos por faixa etária:</h2>
                <div id="ageChart"></div>
                <script type="text/javascript">
					google.charts.setOnLoadCallback(drawAgeChart);
					function drawAgeChart() {
						var data = google.visualization.arrayToDataTable([
							['Nome', 'Idade'],
							<?php
							
							$sql = '
								
									SELECT
										detalhes_usuario.nome, EXTRACT(YEAR FROM AGE(detalhes_usuario.data_nasc)) AS idade
									FROM
										venda
									INNER JOIN
										venda_item
									ON
										venda_item.id = venda.id
									INNER JOIN
										detalhes_usuario
									ON
										detalhes_usuario.id = venda.usuario
								
								';
								$ages = pg_query($connection, $sql);
								for($k = 0; $k < pg_num_rows($ages); $k++) {
									$age = pg_fetch_array($ages);
									echo "['".$age['nome']."',".$age['idade']."]";
									if($k+1 < pg_num_rows($ages)) {
										echo ',';
									}
								}
								
								?>
							
							]);
				
						var options = {
						  	title: '',
						  	legend: { position: 'none' },
						  	width: 925,
							height: 525,
							histogram: { hideBucketItems: true }
						};
				
						var chart = new google.visualization.Histogram(document.getElementById('ageChart'));
						chart.draw(data, options);
					  }
                </script>
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