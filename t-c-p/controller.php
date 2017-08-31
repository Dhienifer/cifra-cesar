<?php

if( isset($_POST['mensagem']) && isset($_POST['chave']) && isset($_POST['acao']) ){
	
	$mensagem = trim($_POST['mensagem']);
	$chave = $_POST['chave'];
	$acao = $_POST['acao'];
	
	function funcaoParaLimparMensagem($mensagem){
				
		$esse = [
			"á","à","ã","â","ä","Á","À","Ã","Â","Ä","é","è","ê","ë","É","È","Ê",
			"Ë","í","ì","î","ï","Í","Ì","Î","Ï","ó","ò","õ","ô","ö","Ó","Ò","Õ","Ô","Ö","ú",
			"ù","û","ü","Ú","Ù","Û","Ü",'ñ','Ñ','ç','Ç',
			'(',')',',',';',':','|','!','"','#','$','%','&','/','=','?','~','^','>','<','ª','º' 
		];
		
		$para_esse = [
			'a','a','a','a','a','A','A','A','A','A','e',
			'e','e','e','E','E','E','E','i','i','i','i','I','I','I','I',
			'o','o','o','o','o','O','O','O','O','O',
			'u','u','u','u','U','U','U','U','n','N','c','C',
			'','','','','','','','','','','','','','','','','','','','',''
		];

		$mensagem = str_replace($esse, $para_esse, $mensagem);
		$mensagem = strtolower($mensagem);

		return $mensagem;
	}
	

	$mensagem = funcaoParaLimparMensagem($mensagem);
	
	$vetorCaracterPorCaracter = str_split($mensagem);
	
	// $acao valor 1 para codificar
	// $acao valor 2 para decodificar
	// $acao valor 3 para automatico
	
	if($acao  == '1' || $acao  == '2' ){
		
		if(!is_numeric($chave) or $chave < 0) 
			$chave = 0;
		
		$mensagemReconstruida = null;
		
		foreach($vetorCaracterPorCaracter as $caracter){
			
			$valorAsciiDoCaracter = ord($caracter);
			
			if($valorAsciiDoCaracter < 32 || $valorAsciiDoCaracter > 126)
				continue;
			
			switch($acao){
				case '1':
					$valorAsciiDoCaracter+= $chave;
					while($valorAsciiDoCaracter > 126)
						$valorAsciiDoCaracter-= 94;	
				break;
				case '2':
					$valorAsciiDoCaracter-= $chave;
					while($valorAsciiDoCaracter < 32)
						$valorAsciiDoCaracter+= 94;
				break;
				
			}
			
			$mensagemReconstruida.= chr($valorAsciiDoCaracter);
		}
		
		$retorno = $mensagemReconstruida;
		
	}else if($acao  == '3'){
	
		$i = 32; 
		
		while($i <= 126){
			
			$mensagemReconstruida = '';
			
			foreach($vetorCaracterPorCaracter as $caracter){
				
				$valorAsciiDoCaracter = ord($caracter) - $i;
				
				if($valorAsciiDoCaracter < 32 or $valorAsciiDoCaracter > 126)
					continue;
			
				while($valorAsciiDoCaracter < 32)
					$valorAsciiDoCaracter+= 94;
				
					$mensagemReconstruida.= chr($valorAsciiDoCaracter);
			
			}
			
			if($mensagemReconstruida)
				$vetorMensagemReconstruida[] = $mensagemReconstruida;
			
			$i++;
		}
		
		$bancoTXT = "arquivo_banco_de_palavras.txt";
		
		$palavrasTXT = file($bancoTXT,FILE_IGNORE_NEW_LINES);
			
		foreach($vetorMensagemReconstruida as $mensagemReconstruida){
			
			$palavrasDaMensagem = explode(' ',$mensagemReconstruida);
			
			$ocorrencias = 0;
			
			foreach($palavrasDaMensagem as $palavra){
				
				$palavra = strtolower($palavra);
				
				foreach($palavrasTXT as $pTXT){
					
					if( $palavra && substr_count($palavra, $pTXT) )
						$ocorrencias++;
					
				}
				
			}
			
			$vetorQuantidadesDeOcorrencias[] = $ocorrencias;
		}
		
		$maiorOcorrencia = max($vetorQuantidadesDeOcorrencias);
		
		
		$keyVetorDaMaiorOcorrencia = array_search($maiorOcorrencia, $vetorQuantidadesDeOcorrencias);
		
		$retorno = [
			'provavel' => $vetorMensagemReconstruida[$keyVetorDaMaiorOcorrencia] ,
			'todas' => 	$vetorMensagemReconstruida		
		];

	}
}
	
