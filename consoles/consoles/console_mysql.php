<?php

date_default_timezone_set("America/Sao_Paulo");

$curdir = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR;
require_once($curdir . "../functions/connection.php");
require_once($curdir . "../functions/functions_basics.php");
require_once($curdir . "../functions/functions_clientes.php");
require_once($curdir . "../functions/functions_criacao.php");

$conn 		= conectaDB();

while(1)
{
	$clientes = listaClientes($conn, 0, 2);

	if(!empty($clientes) && is_array($clientes))
	{
		foreach($clientes as $cliente)
		{
			echo "Inciando processo do cliente: " . $cliente['clientes_nome'] . " (" . $cliente['clientes_id'] . ")\n";

			// Conecta ao banco de dados do cliente
			$conn_cliente = conectaDB($cliente['clientes_host'], $cliente['clientes_userdb'], $cliente['clientes_passdb'], $cliente['clientes_db']);

			// Lista todas as colunas do cliente
			$colunas_db = listaColunas($conn_cliente, $cliente['clientes_db']);

			if(is_array($colunas_db) && !empty($colunas_db))
			{
				$colunas = Array();

				$tabelas = Array();
				
				// Organiza colunas de cada cliente
				$tabela_antiga = "";
				foreach($colunas_db as $i => $coluna_db)
				{
					$colunas[$coluna_db['TABLE_NAME']][$i]['nome_coluna'] = $coluna_db['COLUMN_NAME'];
					$colunas[$coluna_db['TABLE_NAME']][$i]['obrigatorio'] = $coluna_db['IS_NULLABLE'] == 'NO' ? 1 : 0;
					$colunas[$coluna_db['TABLE_NAME']][$i]['tipo'] = $coluna_db['DATA_TYPE'];
					$colunas[$coluna_db['TABLE_NAME']][$i]['tamanho_maximo'] = $coluna_db['CHARACTER_MAXIMUM_LENGTH'];
					$colunas[$coluna_db['TABLE_NAME']][$i]['comentario'] = $coluna_db['COLUMN_COMMENT'];
					$colunas[$coluna_db['TABLE_NAME']][$i]['chave'] = $coluna_db['COLUMN_KEY'];
					$colunas[$coluna_db['TABLE_NAME']][$i]['extra'] = $coluna_db['EXTRA'];

					if($tabela_antiga != $coluna_db['TABLE_NAME'])
						$tabelas[] = $coluna_db['TABLE_NAME'];
					
					$tabela_antiga = $coluna_db['TABLE_NAME'];
				}

				// Cria pasta do cliente (caso exista, remove tudo e recria)
				if(!is_dir("../clientes/" . $cliente['clientes_id']))
					mkdir("../clientes/" . $cliente['clientes_id'], 0777, true);
				else
				{
					removeDiretorioRecursivamente("../clientes/" . $cliente['clientes_id']);
					mkdir("../clientes/" . $cliente['clientes_id'], 0777, true);
				}

				deletaDocsCliente($conn, $cliente['clientes_id']);

				//criaSwagger($conn, $cliente, $tabelas, $colunas);
				criaFuncoes("conectaDB('$cliente[clientes_host]', '$cliente[clientes_userdb]', '$cliente[clientes_passdb]', '$cliente[clientes_db]')", $conn, $cliente, $tabelas, $colunas);

				echo "Finalização com sucesso do cliente: " . $cliente['clientes_nome'] . " (" . $cliente['clientes_id'] . ")\n";
				atualizaStatusCliente($conn, $cliente['clientes_id'], 3); // Arquivos criados
			}
			else
			{
				echo "Erro (101) no processo do cliente: " . $cliente['clientes_nome'] . " (" . $cliente['clientes_id'] . ")\n";
				atualizaStatusCliente($conn, $cliente['clientes_id'], 4); // Erro ao inserir arquivos
			}
		}
	}
	else
		echo "Nenhum cliente encontrado!\n";

	sleep(10);
}
