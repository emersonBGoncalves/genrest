<?php

class pid {

    protected $filename;
    public $already_running = FALSE;
   
    function __construct($directory)
    {
        $this->filename = $directory . '/' . basename($_SERVER['PHP_SELF']) . '.pid';
       
        if(is_writable($this->filename) || is_writable($directory))
        {
            if(file_exists($this->filename))
            {
                $pid = (int)trim(file_get_contents($this->filename));
                if(posix_kill($pid, 0))
                    $this->already_running = TRUE;
            }
        }
        else
            die("Cannot write to pid file '$this->filename'. Program execution halted.\n");
       
        if(!$this->already_running)
        {
            $pid = getmypid();
            file_put_contents($this->filename, $pid);
        }
       
    }   
}

/**
 * Verifica se já tem uma instancia do arquivo em execução,
 * caso tenha encerra a execução deste arquivo
 * @return void
 */
function checkpid()
{
	///// DEBUG /////
	$os = strtoupper(substr(PHP_OS, 0, 3));
	if($os === 'WIN')
	{
		return;
	}
	else
	{
		$console_pid = new pid('/var/run/');
		if($console_pid->already_running)
			die("Processo ja em execucao...\n");
	}
}

function removeDiretorioRecursivamente($src)
{
	if(file_exists($src))
	{
		$os = strtoupper(substr(PHP_OS, 0, 3));
		if($os === 'WIN')
		{
			$src = str_replace('/', '\\', $src);
    		$result = exec("RMDIR /S /Q $src", $saida, $erro);
    		//echo "$result - $src\n"; print_r($saida); print_r($erro); die();

    		if($erro == 0)
    			return true;
			else
				return false; //$saida; 
		}
		else
		{
    		$result = exec("rm -fr $src", $saida, $erro);
    		if($erro == 0)
    			return true;
			else
				return false; //$saida;
		}
	}
	else
		return false;
}

function prettyPrint( $json )
{
    $result = '';
    $level = 0;
    $in_quotes = false;
    $in_escape = false;
    $ends_line_level = NULL;
    $json_length = strlen( $json );

    for( $i = 0; $i < $json_length; $i++ ) {
        $char = $json[$i];
        $new_line_level = NULL;
        $post = "";
        if( $ends_line_level !== NULL ) {
            $new_line_level = $ends_line_level;
            $ends_line_level = NULL;
        }
        if ( $in_escape ) {
            $in_escape = false;
        } else if( $char === '"' ) {
            $in_quotes = !$in_quotes;
        } else if( ! $in_quotes ) {
            switch( $char ) {
                case '}': case ']':
                    $level--;
                    $ends_line_level = NULL;
                    $new_line_level = $level;
                    break;

                case '{': case '[':
                    $level++;
                case ',':
                    $ends_line_level = $level;
                    break;

                case ':':
                    $post = " ";
                    break;

                case " ": case "\t": case "\n": case "\r":
                    $char = "";
                    $ends_line_level = $new_line_level;
                    $new_line_level = NULL;
                    break;
            }
        } else if ( $char === '\\' ) {
            $in_escape = true;
        }
        if( $new_line_level !== NULL ) {
            $result .= "\n".str_repeat( "\t", $new_line_level );
        }
        $result .= $char.$post;
    }

    return $result;
}

function validaHttpMetodoRecebido()
{
	$http_metodos_habilitados = array("GET", "POST", "PUT", "DELETE");

	//Método de envio da solicação exemplo GET, POST, PUT e DELETE
	$ret["http_method"] = $_SERVER['REQUEST_METHOD'];
	if(!in_array($ret["http_method"], $http_metodos_habilitados))
	{
		$ret["http_response_code"] = 405;
		$ret["mensagem"] = "O método utilizado para envio de dados não está habilitado!";
	}
	else
	{
		$ret["http_response_code"] = 200;
		$ret["mensagem"] = "Metodo validado com sucesso!";
	}
	
	return $ret;
}

function printClientData($array_dados, $ignora_header_accept = true)
{
	if(is_array($array_dados) && !empty($array_dados))
	{
		$formatos_retorno_aceito = isset($_SERVER['HTTP_ACCEPT']) ? $_SERVER['HTTP_ACCEPT'] : NULL;
		if((strpos($formatos_retorno_aceito, 'application/json') !== false) || $ignora_header_accept)
		{
			// Seta o tipo de retorno dos dados da página

			// Seta código de resposta do navegador
			http_response_code($array_dados["http_response_code"]);

			// Escreve o retorno no payload
			echo json_encode($array_dados);
		}
		else
		{
			// Seta código de resposta do navegador
			http_response_code(400);
			
			$array_dados["code"] = 400;
			$array_dados["type"] = "unknown";
			$array_dados["message"] = $array_dados["mensagem"];

			// Escreve o retorno no payload
			echo json_encode(array("http_response_code" => 400, "mensagem" => "O método de resposta aceito não é valido."));
		}
	}
	else
	{
		// Seta código de resposta do navegador
		http_response_code(500);
		
		// Escreve o retorno no payload
		echo json_encode(array("http_response_code" => 500, "mensagem" => "Erro Interno"));
	}
}

/**
 * Retorna Array com os dados recebidos pela página
 * @return array
 */
function getDadosHttpRecebidos()
{
	$ret["http_response_code"] = 200;

	$dados_temp1 = Array();
	$dados_temp2 = Array();
	
	if(!empty(file_get_contents("php://input")))
	{
		// Pega o Raw POST DATA
		$input = file_get_contents("php://input");
		if(!empty($input))
		{
			$input = urldecode($input);
			$dados_temp1 = json_decode($input, true);
			// Não esta no formato json, então tenta decodificar o dados recebido usando o método padrão do PHP
			// http://php.net/manual/en/function.parse-str.php
			if(json_last_error() != JSON_ERROR_NONE)
			{
				parse_str($input, $dados_temp1);
			}

			//Não conseguiu gerar o array de dados, então provavelmente o dados do input esta no padrão query_string
			if(is_null($dados_temp1) && is_string($input))
				$dados_temp1 = converteQueryStringToArray($input);
		}
	}

	// Pega parametros enviados via GET
	if(!empty($_SERVER["QUERY_STRING"]))
		$dados_temp2 = converteQueryStringToArray($_SERVER["QUERY_STRING"]);

	if(empty($dados_temp1))
	{
		if(!empty($_SERVER["CONTENT_TYPE"]))
		{
			// Não encontramos nenhum dado então verifica se o método de envio foi 'POST' e o seu content_type é 'multipart/form-data'
			// php://input is not available with enctype="multipart/form-data"
			$content_type = trim(strtolower($_SERVER["CONTENT_TYPE"]));
			$http_method = $_SERVER['REQUEST_METHOD'];
			if($http_method == "POST" && strpos($content_type, "multipart/form-data") !== false)
			{
				print_debug("# Foi enviado um 'POST' com o padrão 'multipart/form-data'");
				print_debug("# campos recebidos POST (INICIO)");
				foreach ($_POST as $key => $value) 
				{
					print_debug("## " . $key . ": " . json_encode($value));
					$dados_temp1[$key] = $value;
				}

				if(!empty($_FILES))
				{
					print_debug("## Um arquivo foi recebido pelo sistema...");
					foreach ($_FILES as $key => $value) 
					{
						print_debug("## " . $key . " => " . json_encode($value));
						$dados_temp1["arquivos"][$key] = $value;
					}
				}
				print_debug("# campos recebidos (FIM)");
			}
		}
		else if(empty($dados_temp2))
		{
			printClientData("dados não encontrados");
			die();
		}
	}

	$ret['dados'] = array_merge($dados_temp1, $dados_temp2);
	return $ret;
}

/**
 * Converte uma Query string para um Array.
 * @param string $query_string Query a ser convertida
 * @return array
 */
function converteQueryStringToArray($query_string)
{
	$dados = Array();
	$query_string_exp = explode("&", $query_string);
	foreach($query_string_exp AS $array_valores)
	{
		$array_valores_exp = explode("=", $array_valores);
		if(is_array($array_valores_exp) && count($array_valores_exp) == 2)
		{
			$chave = $array_valores_exp[0];
			$valor = $array_valores_exp[1];

			if(strpos($chave, "[") !== FALSE)
			{
				$chave_tmp = str_replace("]", "", $chave);
				$ret_exp = explode("[", $chave_tmp);
				if(count($ret_exp) == 2)
				{
					if(empty($dados[$ret_exp[0]]))
						$dados[$ret_exp[0]] = Array("$ret_exp[1]" => $valor);
					else
					{
						$tmp_array_dados[$ret_exp[0]] = Array("$ret_exp[1]" => $valor);
						$dados[$ret_exp[0]] = array_merge($dados[$ret_exp[0]], $tmp_array_dados[$ret_exp[0]]);
					}
				}
			}
			else
			{
				$dados[$chave] = $valor;
			}
		}

		unset($array_valores_exp);
	}
	
	return $dados;
}

function validaCampo($dados, $chave, $codigo_erro_validacao, $tipo_validacao = 0, $nome_campo = NULL)
{
	if(empty($nome_campo))
		$nome_campo = $chave;

	if($chave == "dados" && !isset($dados[$chave]))
		return $dados;
	
	if(!isset($dados[$chave]))
	{
		$dados["http_response_code"] = $codigo_erro_validacao;
		$dados["mensagem"] = "O campo $nome_campo deve ser preenchido!";

		printClientData($dados);
		die();
	}
	if($tipo_validacao == 1 && !is_numeric($dados[$chave]))
	{
		$dados["http_response_code"] = $codigo_erro_validacao;
		$dados["mensagem"] = "O campo $nome_campo deve ser preenchido com um valor do tipo númerico!";

		printClientData($dados);
		die();
	}
	else if($tipo_validacao != 1 && empty($dados[$chave]))
	{
		$dados["http_response_code"] = $codigo_erro_validacao;
		$dados["mensagem"] = "O campo $nome_campo deve ser preenchido!";

		printClientData($dados);
		die();
	}

	return $dados[$chave];
}

function printTokenInvalido()
{
	$ret = Array();
	$ret["http_response_code"] = 401;
	$ret["mensagem"] = "Dados de autenticação inválidos";

	printClientData($ret);
}

function print_debug($msg){}

function insereLog($conn, $cliente_id, $dados, $usuario)
{
	$query = sprintf("INSERT INTO logs
					( logs_cliente_id, logs_dados, logs_data, logs_usuario ) 
					VALUES
					( %d , '%s',  NOW(), '%s') ",
						mysqli_escape_string($conn, $cliente_id),
						mysqli_escape_string($conn, $dados),
						mysqli_escape_string($conn, $usuario));
	
	//die($query);
	if(mysqli_query($conn, $query))
		return mysqli_insert_id($conn);
	else
		return false;
}