<?php

function listaTokensIntegracao($conn, $cliente_id = NULL, $usuario = NULL)
{
	$query = " SELECT * FROM tokens WHERE 1 = 1 ";
	
	if(isset($cliente_id) && is_numeric($cliente_id))
		$query .= sprintf(" AND tokens_cliente_id = %d ", mysqli_escape_string($conn, $cliente_id));
	
	if(!empty($usuario))
		$query .= sprintf(" AND tokens_usuario LIKE '%s' ", mysqli_escape_string($conn, $usuario));
		
	//echo $query;
	$result = mysqli_query($conn, $query);
	if($result !== FALSE)
		return mysqli_fetch_all_mod($result, MYSQLI_ASSOC);
	else
		return false;
}

function atualizaTokenIntegracaoDataUltimo($conn, $cliente_id, $usuario)
{
	$query = sprintf("	UPDATE tokens 
						SET tokens_data_ultimo_acesso = NOW()
						WHERE tokens_cliente_id = %d AND tokens_usuario = '%s' ",
						mysqli_escape_string($conn, $cliente_id),
						mysqli_escape_string($conn, $usuario));
	//echo $query;
	$result = mysqli_query($conn, $query);
	if($result !== FALSE)
		return true;
	else
		return "ERRO: " . mysqli_error($conn);
}