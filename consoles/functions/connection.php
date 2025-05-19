<?php

function conectaDB($host = NULL, $user = NULL, $pass = NULL, $db_name = NULL)
{	
	$link = mysqli_init();
	if (!$link)
    	die('Setting MYSQLI_INIT_COMMAND failed');
	
	if (!mysqli_options($link, MYSQLI_OPT_CONNECT_TIMEOUT, 3))
    	die('Setting MYSQLI_OPT_CONNECT_TIMEOUT failed');

	if(empty($host) && empty($user) && empty($pass))
	{
		if(!mysqli_real_connect($link, "genrest.cwyf2g7tqmmw.sa-east-1.rds.amazonaws.com" , "admin", "123456789", "genrest"))
			die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
	}
	else
	{
		if(empty($db_name))
		{
			if(!mysqli_real_connect($link, $host, $user, $pass))
			{
				echo 'Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error();
				die();
			}
		}
		else
		{
			if(!mysqli_real_connect($link, $host, $user, $pass, $db_name))
			{
				echo 'Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error();
				die();
			}
		}
	}
	
	mysqli_set_charset($link, "utf8");
	
	return $link;
}

function mysqli_fetch_all_mod($result, $assoc = MYSQLI_ASSOC)
{
	$retorno = array();
	
	if ($assoc == MYSQLI_ASSOC)
	{
		while($linha = mysqli_fetch_array($result, MYSQLI_ASSOC))
			$retorno[] = $linha;
	}
	else if ($assoc == MYSQLI_NUM)
	{
		while($linha = mysqli_fetch_array($result, MYSQLI_NUM))
			$retorno[] = $linha;
	}
	else 
	{
		while($linha= mysqli_fetch_array($result, MYSQLI_BOTH))
			$retorno[] = $linha;
	}	
	
	return $retorno;
}

function listaColunas($conn_cliente, $schema)
{
	$query = "SELECT TABLE_CATALOG
					,TABLE_SCHEMA
					,TABLE_NAME
					,COLUMN_NAME
					,COLUMN_DEFAULT
					,IS_NULLABLE
					,DATA_TYPE
					,CHARACTER_MAXIMUM_LENGTH
					,COLUMN_COMMENT
					,COLUMN_KEY
					,EXTRA
				FROM information_schema.columns
				WHERE TABLE_SCHEMA = '$schema'
				ORDER BY TABLE_NAME";
	
	//echo $query;die;
	$result = mysqli_query($conn_cliente, $query);

	if($result !== FALSE)
		return mysqli_fetch_all_mod($result, MYSQLI_ASSOC);
	else
		return "ERRO: " . mysqli_error($conn_cliente);
}