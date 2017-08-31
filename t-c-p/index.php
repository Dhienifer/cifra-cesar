<?php

	$mensagem = ''; 
	$chave = 0;
	$acao = 0;
	$retorno = '';
	
	include 'controller.php';
	
?>
<html lang='pt-br'>
	<head>
		<title>Trabalho de Segurança</title>
		<link rel='stylesheet' type='text/css' href='bootstrap\css\bootstrap.css'>
		<style>
			#row-conteudo{
				margin-top:5%;
			}
			form textarea{
				min-height:160px;
				resize: vertical;
			}

		</style>
	</head>
	<body>
		<div class="container">
			<div class="row" id='row-conteudo'>
				<div class="col-md-8 col-md-offset-2">
					<div class="panel panel-default">
						<div class="panel-heading"><strong>Formulario para Codificar ou decodificar usando Cifra de cesar.</strong></div>

						<div class="panel-body">
							
							<form class="form col-sm-12" method="POST">
							
								<div class="form-group col-sm-12">
									<label for="mensagem">Mensagem:</label>
									<textarea class="form-control" name='mensagem' rows="5" id="mensagem" placeholder='digite uma mensagem' required></textarea>
								</div>
								
								<div class="form-group col-sm-3">
									<label for="chave">chave:</label>
									<input type="number" min='0' name='chave' class="form-control" placeholder='numero positivo' id="chave">
								</div>
								
								<div class="radio col-sm-12">
									<label class="radio-inline"><input type="radio" name="acao" value='1' required >Codificar</label>
									<label class="radio-inline"><input type="radio" name="acao" value='2' required >Decodificar</label>
									<label class="radio-inline"><input type="radio" name="acao" value='3' required >Automatico</label>
								</div>
								
								<div class="form-group"> 
									<div class="col-sm-10">
										<button type="submit" class="btn btn-default">Enviar</button>
									</div>
								</div>
							</form>
							
							<div class='row col-sm-12'>
								<?php
								
									if($acao == 1 ){
										echo "<h3>Codificação</h3>";
										echo "<h4>Mensagem:</h4>";
										echo $_POST['mensagem'];
										echo "<h4>Chave: {$chave}</h4>";
										echo "<h4>Saida:</h4>";
										echo $retorno;
									}	
									
									if($acao == 2 ){
										echo "<h3>Decodificação</h3>";
										echo "<h4>Mensagem:</h4>";
										echo $_POST['mensagem'];
										echo "<h4>Chave: {$chave}</h4>";
										echo "<h4>Saida:</h4>";
										echo $retorno;
									}									
									
									if($acao == 3 ){
										echo "<h3>Automatico</h3>";
										echo "<h4>Mensagem: {$_POST['mensagem']}</h4>";
									
										echo "<h4>Provavel Mesagem:</h4>";
										echo $retorno['provavel'];
										echo "<h4>Todas Conbinações da Maquina:</h4>";
										var_dump($retorno['todas']);
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>