<?php

function listaClientes($conn, $id, $status = NULL)
{
	$query = "SELECT * FROM clientes INNER JOIN clientes_permissoes on clientes_permissoes.id_cliente = clientes.clientes_id WHERE 1=1 ";
	
	// WHERE
	if(!empty($id))
		$query .= " AND clientes.clientes_id = " . mysqli_real_escape_string($conn, $id);
	
	if(is_numeric($status))
		$query .= " AND id_permissao = " . mysqli_real_escape_string($conn, $status);
	
	//echo $query;die;
	$result = mysqli_query($conn, $query);

	if($result !== FALSE)
		return mysqli_fetch_all_mod($result, MYSQLI_ASSOC);
	else
		return "ERRO: " . mysqli_error($conn);
}

function retornaEmailCliente($conn, $id)
{
	$query = "SELECT clientes_email FROM clientes WHERE clientes_id= " . mysqli_real_escape_string($conn, $id);
	
	//echo $query;die;
	$result = mysqli_query($conn, $query);

	if($result !== FALSE)
	{
		$fetch = mysqli_fetch_all_mod($result, MYSQLI_ASSOC);
		return $fetch[0]['clientes_email'];
	}
	else
		return "ERRO: " . mysqli_error($conn);
}

function retornaSwaggerByID($conn, $id)
{
	$query = "SELECT clientes_swagger FROM clientes WHERE clientes_swagger_id = '" . mysqli_real_escape_string($conn, $id) . "'";
	
	//echo $query;die;
	$result = mysqli_query($conn, $query);

	if($result !== FALSE)
	{
		$fetch = mysqli_fetch_all_mod($result, MYSQLI_ASSOC);
		if(is_array($fetch) && !empty($fetch))
			return $fetch[0]['clientes_swagger'];
		else
			return false;
	}
	else
		return false;
}

function atualizaStatusCliente($conn, $id , $status)
{
	$query = sprintf("UPDATE clientes_permissoes SET id_permissao = %d WHERE id_cliente = %d", mysqli_escape_string($conn, $status), mysqli_escape_string($conn, $id));

	//echo $query;die;
	if(mysqli_query($conn, $query))
		return true;
	else
	{
		return " ERRO: ".mysqli_error($conn);
	}
}

function atualizaSwaggerCliente($conn, $id, $swagger, $swagger_id)
{
	$query = sprintf("UPDATE clientes SET clientes_swagger = '%s', clientes_swagger_id = '%s' WHERE clientes_id = %d", mysqli_escape_string($conn, $swagger), mysqli_escape_string($conn, $swagger_id), mysqli_escape_string($conn, $id));

	//echo $query;die;
	if(mysqli_query($conn, $query))
		return true;
	else
	{
		return " ERRO: ".mysqli_error($conn);
	}
}

function atualizaQuantidadeFuncoesCliente($conn, $id , $qtd)
{
	$query = sprintf("UPDATE clientes SET clientes_qtd_funcoes = %d WHERE clientes_id = %d", mysqli_escape_string($conn, $qtd), mysqli_escape_string($conn, $id));

	//echo $query;die;
	if(mysqli_query($conn, $query))
		return true;
	else
	{
		return " ERRO: ".mysqli_error($conn);
	}
}

function retornaTokenValido($conn, $dados)
{
	// Caso o tipo de dado recebido sejá do tipo "multipart/form-data", os dados de autenticação estão fora de uma estrutura.
	$content_type = !empty($_SERVER["CONTENT_TYPE"]) ? trim(strtolower($_SERVER["CONTENT_TYPE"])) : "";
	$http_method = $_SERVER['REQUEST_METHOD'];
	
	if(($http_method == "POST" && strpos($content_type, "multipart/form-data")) || $http_method == "GET")
	{
		if(!empty($dados["autenticacao"]["usuario"]) && !empty($dados["autenticacao"]["token"]))
		{
			$usuario 	= $dados["autenticacao"]["usuario"];
			$token 		= $dados["autenticacao"]["token"];
		}
		else
		{
			$ret["validado"] = false;
			return $ret;
		}
	}
	else
	{
		$autenticacao 	= validaCampo($dados, "autenticacao", 400, 0);
		if(!empty($autenticacao["usuario"]) && !empty($autenticacao["token"]))
		{
			$usuario = $autenticacao["usuario"];
			$token 	= $autenticacao["token"];
		}
	}
	
	if(empty($usuario))
	{
		printTokenInvalido();
		die();
	}
	
	$ret = Array();

	$curdir = dirname( realpath( __FILE__ ) ) . DIRECTORY_SEPARATOR;
	require_once($curdir . "functions_tokens.php");

	
	$tokens = listaTokensIntegracao($conn, NULL, $usuario);
	if(is_array($tokens) && count($tokens) == 1)
	{
		if(password_verify($token, $tokens[0]["tokens_hash"]))
		{
			$cliente_id = $tokens[0]["tokens_cliente_id"];

			atualizaTokenIntegracaoDataUltimo($conn, $cliente_id, $usuario);

			$ret["validado"] 	= true;
			$ret["usuario"] 	= $usuario;
			$ret["cliente_id"] 	= $cliente_id;
			return $ret;
		}
	}
	
	$ret["validado"] = false;
	return $ret;
}

function insereDocCliente($conn, $cliente_id, $dados)
{
	$query = sprintf(
		"INSERT INTO clientes_doc
					(clientes_doc_cliente_id, clientes_doc_id_dados ) 
					VALUES
					( %d , '%s') ",
		mysqli_escape_string($conn, $cliente_id),
		mysqli_escape_string($conn, $dados)
	);

	//die($query);
	if (mysqli_query($conn, $query))
	return mysqli_insert_id($conn);
	else
	return false;
}

function deletaDocsCliente($conn, $cliente_id)
{
	$query = "DELETE
				FROM clientes_doc
				WHERE clientes_doc_cliente_id = $cliente_id";

	$result = mysqli_query($conn, $query);

	if ($result !== false) {
		return true;
	} else {
		return false;
	}
}