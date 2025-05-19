<?php
/*
function criaSwagger($conn, $cliente, $tabelas, $colunas)
{
	require_once("functions_clientes.php");
	echo "Criando arquivo swagger do cliente: " . $cliente['clientes_nome'] . " (" . $cliente['clientes_id'] . ")\n";

	$array_swagger[0]['swagger'] = '2.0';
	$array_swagger[0]['info']['description'] = 'Essa documentação serve como modelo para chamadas da API';
	$array_swagger[0]['info']['version'] = '1.0.0';
	$array_swagger[0]['info']['title'] = 'Documentação Genrest - ' . $cliente['clientes_nome'] . '';
	$array_swagger[0]['info']['contact']['email'] = 'contato@genrest.com.br';
	$array_swagger[0]['host'] = '52.67.72.247/index.php/';
	$array_swagger[0]['basePath'] = '';
			
	foreach($tabelas as $key => $tabela)
	{
		$array_swagger[0]['tags'][$key]['name'] = $tabela;
		$array_swagger[0]['tags'][$key]['description'] = "Todas as ações relacionadas a " . $tabela;
	}

	$array_swagger[0]['schemes'] = Array("http");
	$array_swagger[0]['paths'] = Array();

	$array_swagger[0]['definitions']['Autenticacao']['type'] = 'object';
	$array_swagger[0]['definitions']['Autenticacao']['properties']['usuario']['type'] = 'string';
	$array_swagger[0]['definitions']['Autenticacao']['properties']['usuario']['description'] = 'Usuário de Autenticacao.';
	$array_swagger[0]['definitions']['Autenticacao']['properties']['usuario']['example'] = '';
	$array_swagger[0]['definitions']['Autenticacao']['properties']['token']['type'] = 'string';
	$array_swagger[0]['definitions']['Autenticacao']['properties']['token']['description'] = 'Token de acesso.';
	$array_swagger[0]['definitions']['Autenticacao']['properties']['token']['example'] = '';
	$array_swagger[0]['definitions']['Autenticacao']['xml']['name'] = 'Autenticacao';

	$char_tabelas = "";
	foreach($tabelas as $tabela)
	{
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)] = Array();
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['tags'][0] = $tabela;
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['summary'] = "Busca na tabela $tabela";
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['description'] = '';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['operationId'] = "listar_" . strtolower($tabela);
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['consumes'][] = 'application/json';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['produces'][] = 'application/json';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['in'] = 'body';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['name'] = 'body';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['description'] = "Informação sobre a autenticação e filtros para busca na tabela $tabela";
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['required'] = true;
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties']['autenticacao']["\$ref"] = '#/definitions/Autenticacao';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties']['acao']['type'] = 'string';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties']['acao']['example'] = "listar_" . strtolower($tabela);
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties']['acao']['default'] = "listar_" . strtolower($tabela);
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties']['acao']['description'] = 'Ação a ser realizada.';
		
		$array_swagger[0]['definitions'][$tabela]['type'] = 'object';
		$array_swagger[0]['definitions'][$tabela]['properties'] = Array();
		

		foreach($colunas[$tabela] as $key => $coluna)
		{
			if($coluna['tipo'] == "tinyint" || $coluna['tipo'] == "smallint" || $coluna['tipo'] == "mediumint"
					|| $coluna['tipo'] == "int" || $coluna['tipo'] == "bigint" || $coluna['tipo'] == "decimal"
					|| $coluna['tipo'] == "float" || $coluna['tipo'] == "double" || $coluna['tipo'] == "bit")
			{
				$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties'][$coluna['nome_coluna']]['type'] = 'integer';
				$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties'][$coluna['nome_coluna']]['format'] = 'int64';
				$array_swagger[0]['definitions'][$tabela]['properties'][$coluna['nome_coluna']]['type'] = 'integer';
				$array_swagger[0]['definitions'][$tabela]['properties'][$coluna['nome_coluna']]['format'] = 'int64';
			}
			else
			{
				$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties'][$coluna['nome_coluna']]['type'] = 'string';
				$array_swagger[0]['definitions'][$tabela]['properties'][$coluna['nome_coluna']]['type'] = 'string';
			}

			$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties'][$coluna['nome_coluna']]['description'] = $coluna['comentario'];
			$array_swagger[0]['definitions'][$tabela]['properties'][$coluna['nome_coluna']]['description'] = $coluna['comentario'];
		}

		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties']['registro_inicial']['type'] = 'integer';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties']['registro_inicial']['format'] = 'int64';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties']['registro_inicial']['description'] = 'Registro inicial da busca.';

		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties']['quantidade_limite']['type'] = 'integer';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties']['quantidade_limite']['format'] = 'int64';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties']['quantidade_limite']['description'] = 'Quantidade limite de retornos da busca.';

		$array_swagger[0]['definitions'][$tabela]['xml']['name'] = $tabela;
		
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['200']['description'] = 'Retorno da busca';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['200']['schema']['properties']['http_response_code']['type'] = 'integer';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['200']['schema']['properties']['http_response_code']['format'] = 'int32';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['200']['schema']['properties']['qtd_total_resultados']['type'] = 'integer';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['200']['schema']['properties']['qtd_total_resultados']['format'] = 'int32';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['200']['schema']['properties']['qtd_total_resultados']['minimum'] = '0';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['200']['schema']['properties']['qtd_resultados_retornados']['type'] = 'integer';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['200']['schema']['properties']['qtd_resultados_retornados']['format'] = 'int32';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['200']['schema']['properties']['qtd_resultados_retornados']['minimum'] = '0';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['200']['schema']['properties']['mensagem']['type'] = 'string';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['200']['schema']['properties']['dados']['type'] = 'array';
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['200']['schema']['properties']['dados']['items']["\$ref"] = "#/definitions/$tabela";

		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['400']['description'] = "Erro na validação do campos enviados";
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['400']['schema']['type'] = "array";
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['400']['schema']['items']["\$ref"] = "#/definitions/ApiResponse";

		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['401']['description'] = "Dados de autenticação inválidos";
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['401']['schema']['type'] = "array";
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['401']['schema']['items']["\$ref"] = "#/definitions/ApiResponse";

		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['404']['description'] = "Dado não encontrado";
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['404']['schema']['type'] = "array";
		$array_swagger[0]['paths']["/listar_" . strtolower($tabela)]['post']['responses']['404']['schema']['items']["\$ref"] = "#/definitions/ApiResponse";
	}
	
	if($cliente['clientes_habilita_insert'] == 1)
	{
		foreach($tabelas as $tabela)
		{
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)] = Array();
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['tags'][0] = $tabela;
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['summary'] = "Insere na tabela $tabela";
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['description'] = '';
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['operationId'] = "inserir_" . strtolower($tabela) . "";
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['consumes'][] = 'application/json';
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['produces'][] = 'application/json';
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['parameters'][0]['in'] = 'body';
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['parameters'][0]['name'] = 'body';
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['parameters'][0]['description'] = "Informação sobre a autenticação e filtros para inserção na tabela $tabela";
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['parameters'][0]['required'] = true;
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties']['autenticacao']["\$ref"] = '#/definitions/Autenticacao';
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties']['acao']['type'] = 'string';
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties']['acao']['example'] = "inserir_" . strtolower($tabela);
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties']['acao']['default'] = "inserir_" . strtolower($tabela);
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties']['acao']['description'] = 'Ação a ser realizada.';
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['parameters'][0]['schema']['properties']['dados']["\$ref"] = "#/definitions/$tabela";

			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['responses']['200']['description'] = "'Retorno da inserção";
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['responses']['200']['schema']['properties']['http_response_code']['type'] = "integer";
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['responses']['200']['schema']['properties']['http_response_code']['format'] = "int32";
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['responses']['200']['schema']['properties']['mensagem']['type'] = "string";

			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['responses']['400']['description'] = "Erro na validação do campos enviados";
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['responses']['400']['schema']['type'] = "array";
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['responses']['400']['schema']['items']["\$ref"] = "#/definitions/ApiResponse";

			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['responses']['401']['description'] = "Dados de autenticação inválidos";
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['responses']['401']['schema']['type'] = "array";
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['responses']['401']['schema']['items']["\$ref"] = "#/definitions/ApiResponse";

			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['responses']['404']['description'] = "Dado não encontrado";
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['responses']['404']['schema']['type'] = "array";
			$array_swagger[0]['paths']["/inserir_" . strtolower($tabela)]['post']['responses']['404']['schema']['items']["\$ref"] = "#/definitions/ApiResponse";
		}
	}

	if($cliente['clientes_habilita_update'] == 1)
	{
		foreach($tabelas as $tabela)
		{
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)] = Array();
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['tags'][0] = $tabela;
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['summary'] = "Edita na tabela $tabela";
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['description'] = '';
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['operationId'] = "alterar_" . strtolower($tabela) . "";
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['consumes'][] = 'application/json';
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['produces'][] = 'application/json';
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['parameters'][0]['in'] = 'body';
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['parameters'][0]['name'] = 'body';
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['parameters'][0]['description'] = "Informação sobre a autenticação e filtros para edição na tabela $tabela";
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['parameters'][0]['required'] = true;
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['parameters'][0]['schema']['properties']['autenticacao']["\$ref"] = '#/definitions/Autenticacao';
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['parameters'][0]['schema']['properties']['acao']['type'] = 'string';
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['parameters'][0]['schema']['properties']['acao']['example'] = "alterar_" . strtolower($tabela);
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['parameters'][0]['schema']['properties']['acao']['default'] = "alterar_" . strtolower($tabela);
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['parameters'][0]['schema']['properties']['acao']['description'] = 'Ação a ser realizada.';
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['parameters'][0]['schema']['properties']['dados']["\$ref"] = "#/definitions/$tabela";

			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['responses']['200']['description'] = "'Retorno da edição";
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['responses']['200']['schema']['properties']['http_response_code']['type'] = "integer";
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['responses']['200']['schema']['properties']['http_response_code']['format'] = "int32";
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['responses']['200']['schema']['properties']['mensagem']['type'] = "string";

			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['responses']['400']['description'] = "Erro na validação do campos enviados";
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['responses']['400']['schema']['type'] = "array";
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['responses']['400']['schema']['items']["\$ref"] = "#/definitions/ApiResponse";

			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['responses']['401']['description'] = "Dados de autenticação inválidos";
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['responses']['401']['schema']['type'] = "array";
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['responses']['401']['schema']['items']["\$ref"] = "#/definitions/ApiResponse";

			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['responses']['404']['description'] = "Dado não encontrado";
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['responses']['404']['schema']['type'] = "array";
			$array_swagger[0]['paths']["/alterar_" . strtolower($tabela)]['put']['responses']['404']['schema']['items']["\$ref"] = "#/definitions/ApiResponse";
		}
	}

	if($cliente['clientes_habilita_delete'] == 1)
	{
		foreach($tabelas as $tabela)
		{
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)] = Array();
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['tags'][0] = $tabela;
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['summary'] = "Deleta na tabela $tabela";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['description'] = '';
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['operationId'] = "deletar_" . strtolower($tabela);
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['consumes'][] = 'application/json';
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['produces'][] = 'application/json';
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['parameters'][0]['in'] = 'body';
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['parameters'][0]['name'] = 'body';
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['parameters'][0]['description'] = "Informação sobre a autenticação e filtros para remoção na tabela $tabela";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['parameters'][0]['required'] = true;
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['parameters'][0]['schema']['properties']['autenticacao']["\$ref"] = '#/definitions/Autenticacao';
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['parameters'][0]['schema']['properties']['acao']['type'] = 'string';
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['parameters'][0]['schema']['properties']['acao']['example'] = "deletar_" . strtolower($tabela);
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['parameters'][0]['schema']['properties']['acao']['default'] = "deletar_" . strtolower($tabela);
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['parameters'][0]['schema']['properties']['acao']['description'] = 'Ação a ser realizada.';

			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['200']['description'] = "'Retorno da remoção";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['200']['schema']['properties']['http_response_code']['type'] = "integer";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['200']['schema']['properties']['http_response_code']['format'] = "int32";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['200']['schema']['properties']['mensagem']['type'] = "string";

			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['400']['description'] = "Erro na validação do campos enviados";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['400']['schema']['type'] = "array";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['400']['schema']['items']["\$ref"] = "#/definitions/ApiResponse";

			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['401']['description'] = "Dados de autenticação inválidos";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['401']['schema']['type'] = "array";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['401']['schema']['items']["\$ref"] = "#/definitions/ApiResponse";

			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['404']['description'] = "Dado não encontrado";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['404']['schema']['type'] = "array";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['404']['schema']['items']["\$ref"] = "#/definitions/ApiResponse";
			
			foreach($colunas[$tabela] as $key => $coluna)
			{
				if($coluna['chave'] != "PRI")
					continue;

				if($coluna['tipo'] == "tinyint" || $coluna['tipo'] == "smallint" || $coluna['tipo'] == "mediumint"
						|| $coluna['tipo'] == "int" || $coluna['tipo'] == "bigint" || $coluna['tipo'] == "decimal"
						|| $coluna['tipo'] == "float" || $coluna['tipo'] == "double" || $coluna['tipo'] == "bit")
				{
					$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['parameters'][0]['schema']['properties'][$coluna['nome_coluna']]['type'] = 'integer';
					$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['parameters'][0]['schema']['properties'][$coluna['nome_coluna']]['format'] = 'int64';
				}
				else
				{
					$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['parameters'][0]['schema']['properties'][$coluna['nome_coluna']]['type'] = 'string';
				}

				$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['parameters'][0]['schema']['properties'][$coluna['nome_coluna']]['description'] = $coluna['comentario'];
			}

			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['200']['description'] = "Dado deletado com sucesso";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['200']['schema']['type'] = "array";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['200']['schema']['items']["\$ref"] = "#/definitions/ApiResponse";

			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['400']['description'] = "Erro na validação do campos enviados";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['400']['schema']['type'] = "array";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['400']['schema']['items']["\$ref"] = "#/definitions/ApiResponse";

			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['401']['description'] = "Dados de autenticação inválidos";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['401']['schema']['type'] = "array";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['401']['schema']['items']["\$ref"] = "#/definitions/ApiResponse";

			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['404']['description'] = "Dado não encontrado";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['404']['schema']['type'] = "array";
			$array_swagger[0]['paths']["/deletar_" . strtolower($tabela)]['delete']['responses']['404']['schema']['items']["\$ref"] = "#/definitions/ApiResponse";
		}
	}

	
	$array_swagger[0]['definitions']['ApiResponse']['type'] = 'object';
	$array_swagger[0]['definitions']['ApiResponse']['properties']['http_response_code']['type'] = 'integer';
	$array_swagger[0]['definitions']['ApiResponse']['properties']['http_response_code']['type'] = 'int32';
	$array_swagger[0]['definitions']['ApiResponse']['properties']['mensagem']['type'] = 'string';

	$html_swagger = json_encode($array_swagger[0]);
	
	atualizaSwaggerCliente($conn, $cliente['clientes_id'], $html_swagger, md5(uniqid(rand(), true)));
	return true;
}*/

function criaFuncoes($conn_cliente, $conn, $cliente, $tabelas, $colunas)
{
	$curdir = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR;
	require_once("functions_clientes.php");

	$qtd_funcoes = 0;
	echo "Criando arquivo de funções do cliente: " . $cliente['clientes_nome'] . " (" . $cliente['clientes_id'] . ")\n";

	$html_funcoes = "<?php ";
	$array_doc = Array();
	foreach($tabelas as $tabela)
	{
		$html_recebendo_campos = "";
		$html_where = "";
		$html_ret_dados = "";

		$array_doc["listar_" . strtolower($tabela)]['cor'] = "#0984e3";
		$array_doc["listar_" . strtolower($tabela)]['nome_funcao'] = "listar_" . strtolower($tabela);
		$array_doc["listar_" . strtolower($tabela)]['campos_obrigatorios'][] = 'autenticacao';
		$array_doc["listar_" . strtolower($tabela)]['campos_obrigatorios'][] = 'acao';
		$array_doc["listar_" . strtolower($tabela)]['campos_obrigatorios'][] = 'registro_inicial';
		$array_doc["listar_" . strtolower($tabela)]['campos_obrigatorios'][] = 'quantidade_limite';

		$array_doc["listar_" . strtolower($tabela)]['campo_corpo']['autenticacao']['usuario'] = '';
		$array_doc["listar_" . strtolower($tabela)]['campo_corpo']['autenticacao']['token'] = '';
		$array_doc["listar_" . strtolower($tabela)]['campo_corpo']['acao'] = "listar_" . strtolower($tabela);

		foreach($colunas[$tabela] as $key => $coluna)
		{
			if($coluna['tipo'] == "tinyint" || $coluna['tipo'] == "smallint" || $coluna['tipo'] == "mediumint"
						|| $coluna['tipo'] == "int" || $coluna['tipo'] == "bigint" || $coluna['tipo'] == "decimal"
						|| $coluna['tipo'] == "float" || $coluna['tipo'] == "double" || $coluna['tipo'] == "bit")
			{
				$html_recebendo_campos .= "\$" . $coluna['nome_coluna'] . " = isset(\$dados['" . $coluna['nome_coluna'] . "']) && is_numeric(\$dados['" . $coluna['nome_coluna'] . "']) ? \$dados['" . $coluna['nome_coluna'] . "'] : NULL; ";
				$array_doc["listar_" . strtolower($tabela)]['campo_corpo'][$coluna['nome_coluna']] = 0;
			}
			else
			{
				$html_recebendo_campos .= "\$" . $coluna['nome_coluna'] . " = !empty(\$dados['" . $coluna['nome_coluna'] . "']) ? \$dados['" . $coluna['nome_coluna'] . "'] : NULL; ";
				$array_doc["listar_" . strtolower($tabela)]['campo_corpo'][$coluna['nome_coluna']] = "";
			}

			$html_where .= "if(!is_null(\$" . $coluna['nome_coluna'] . ")) { ";
			$html_where .= "\$query .= ' AND " . $coluna['nome_coluna'] . " = \"' . \$" . $coluna['nome_coluna'] . " . '\"';";
			$html_where .= "} ";

			$html_ret_dados .= "\$ret_dado['" . $coluna['nome_coluna'] . "'] = \$dado_db['" . $coluna['nome_coluna'] . "'];
			";
		}

		$array_doc["listar_" . strtolower($tabela)]['campo_corpo']['registro_inicial'] = 0;
		$array_doc["listar_" . strtolower($tabela)]['campo_corpo']['quantidade_limite'] = 50;

		$html_recebendo_campos .= "\$registro_inicial = validaCampo(\$dados, 'registro_inicial', 400, 1); ";
		$html_recebendo_campos .= "\$quantidade_limite = validaCampo(\$dados, 'quantidade_limite', 400, 1); ";

		$qtd_funcoes++;
		$html_funcoes .= "function listar_" . strtolower($tabela) . "(\$dados) { ";

		$html_funcoes .= " \$curdir = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR;";

		$html_funcoes .= "require_once(\$curdir . '../../functions/connection.php');";
		$html_funcoes .= "require_once(\$curdir . '../../functions/functions_basics.php');";

		$html_funcoes .= "\$conn_cliente = $conn_cliente;";

		$html_funcoes .= $html_recebendo_campos;

		$html_funcoes .= "\$query = 'SELECT * FROM $tabela WHERE 1 = 1 ';";

		$html_funcoes .= $html_where;

		$html_funcoes .= "\$query .= \" LIMIT \$registro_inicial, \$quantidade_limite \";";

		$html_funcoes .= "\$result = mysqli_query(\$conn_cliente, \$query);";

		$html_funcoes .= "if(\$result !== FALSE)
						{
							\$dados_db = mysqli_fetch_all_mod(\$result, MYSQLI_ASSOC);
							\$ret_dados = Array();
							if(!empty(\$dados_db) && is_array(\$dados_db))
							{
								foreach(\$dados_db as \$dado_db)
								{
									\$ret_dado = Array();
									$html_ret_dados

									\$ret_dados[] = \$ret_dado;
								}
							}
							
							\$ret = Array();
							\$ret['http_response_code'] 		= 200;
							\$ret['qtd_total_resultados'] 		= count(\$ret_dados);
							\$ret['dados'] 						= \$ret_dados;
							\$ret['mensagem'] 					= '';
							printClientData(\$ret);
							die();";
						
		$html_funcoes .= "}
						else
						{
							http_response_code(500);
							echo json_encode(array('http_response_code' => 500, 'mensagem' => 'Erro Interno'));
						}";

		$html_funcoes .= "} ";
	}	

	if($cliente['clientes_habilita_insert'] == 1)
	{
		foreach($tabelas as $tabela)
		{
			$html_recebendo_campos = "";
			$html_campos = "";
			$html_campos_valor = "";

			$array_doc["inserir_" . strtolower($tabela)]['cor'] = "#49cc90";
			$array_doc["inserir_" . strtolower($tabela)]['nome_funcao'] = "inserir_" . strtolower($tabela);
			$array_doc["inserir_" . strtolower($tabela)]['campos_obrigatorios'][] = 'autenticacao';
			$array_doc["inserir_" . strtolower($tabela)]['campos_obrigatorios'][] = 'acao';

			$array_doc["inserir_" . strtolower($tabela)]['campo_corpo']['autenticacao']['usuario'] = '';
			$array_doc["inserir_" . strtolower($tabela)]['campo_corpo']['autenticacao']['token'] = '';
			$array_doc["inserir_" . strtolower($tabela)]['campo_corpo']['acao'] = "inserir_" . strtolower($tabela);
			$array_doc["inserir_" . strtolower($tabela)]['campo_corpo']['dados'] = Array();

			foreach($colunas[$tabela] as $key => $coluna)
			{
				if($coluna['extra'] != 'auto_increment')
				{
					if($coluna['tipo'] == "tinyint" || $coluna['tipo'] == "smallint" || $coluna['tipo'] == "mediumint"
								|| $coluna['tipo'] == "int" || $coluna['tipo'] == "bigint" || $coluna['tipo'] == "decimal"
								|| $coluna['tipo'] == "float" || $coluna['tipo'] == "double" || $coluna['tipo'] == "bit")
					{
						$array_doc["inserir_" . strtolower($tabela)]['campo_corpo']['dados'][$coluna['nome_coluna']] = 0;
						if($coluna['obrigatorio'] == 1)
						{
							$html_recebendo_campos .= "\$" . $coluna['nome_coluna'] . " = validaCampo(\$dados, '" . $coluna['nome_coluna'] . "', 400, 1); ";
							$array_doc["inserir_" . strtolower($tabela)]['campos_obrigatorios'][] = $coluna['nome_coluna'];
						}
						else
							$html_recebendo_campos .= "\$" . $coluna['nome_coluna'] . " = isset(\$dados['" . $coluna['nome_coluna'] . "']) && is_numeric(\$dados['" . $coluna['nome_coluna'] . "']) ? \$dados['" . $coluna['nome_coluna'] . "'] : NULL; ";
					}
					else
					{
						$array_doc["inserir_" . strtolower($tabela)]['campo_corpo']['dados'][$coluna['nome_coluna']] = "";
						if($coluna['obrigatorio'] == 1)
							$html_recebendo_campos .= "\$" . $coluna['nome_coluna'] . " = validaCampo(\$dados, '" . $coluna['nome_coluna'] . "', 400, 0); ";
						else
							$html_recebendo_campos .= "\$" . $coluna['nome_coluna'] . " = !empty(\$dados['" . $coluna['nome_coluna'] . "']) ? \$dados['" . $coluna['nome_coluna'] . "'] : NULL; ";
					}

					if(!empty($html_campos))
					{
						$html_campos .= "," . $coluna['nome_coluna'];
						$html_campos_valor .= ",\"' . \$dados['" . $coluna['nome_coluna'] . "'] . '\"";
					}
					else
					{
						$html_campos .= $coluna['nome_coluna'];
						$html_campos_valor .= "\"' . \$dados['" . $coluna['nome_coluna'] . "'] . '\"";
					}
				}

			}
			
			$qtd_funcoes++;
			$html_funcoes .= "function inserir_" . strtolower($tabela) . "(\$dados) { ";

			$html_funcoes .= " \$curdir = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR;";

			$html_funcoes .= "require_once(\$curdir . '../../functions/connection.php');";
			$html_funcoes .= "require_once(\$curdir . '../../functions/functions_basics.php');";

			$html_funcoes .= "\$conn_cliente = $conn_cliente;";

			$html_funcoes .= $html_recebendo_campos;

			$html_funcoes .= "\$query = 'INSERT INTO $tabela ($html_campos) VALUES ($html_campos_valor);';";

			$html_funcoes .= "\$result = mysqli_query(\$conn_cliente, \$query);";

			$html_funcoes .= "if(\$result !== FALSE)
							{
								\$ret = Array();
								\$ret['http_response_code'] = 200;
								\$ret['id'] = mysqli_insert_id(\$conn_cliente);
								\$ret['mensagem'] = '$tabela cadastrado com sucesso.';
								printClientData(\$ret);
								exit();
							
							}
							else
							{
								\$ret = Array();
								\$ret['http_response_code'] = 400;
								\$ret['mensagem'] = 'Erro ao inserir $tabela.';
								printClientData(\$ret);
								exit();
							}";

			$html_funcoes .= "} ";
		}
	}

	if($cliente['clientes_habilita_update'] == 1)
	{
		foreach($tabelas as $tabela)
		{
			$html_recebendo_campos = "";
			$html_campos = "";
			$pks = Array();

			$array_doc["alterar_" . strtolower($tabela)]['cor'] = "#fca130";
			$array_doc["alterar_" . strtolower($tabela)]['nome_funcao'] = "alterar_" . strtolower($tabela);
			$array_doc["alterar_" . strtolower($tabela)]['campos_obrigatorios'][] = 'autenticacao';
			$array_doc["alterar_" . strtolower($tabela)]['campos_obrigatorios'][] = 'acao';

			$array_doc["alterar_" . strtolower($tabela)]['campo_corpo']['autenticacao']['usuario'] = '';
			$array_doc["alterar_" . strtolower($tabela)]['campo_corpo']['autenticacao']['token'] = '';
			$array_doc["alterar_" . strtolower($tabela)]['campo_corpo']['acao'] = "alterar_" . strtolower($tabela);
			$array_doc["alterar_" . strtolower($tabela)]['campo_corpo']['dados'] = array();

			foreach($colunas[$tabela] as $key => $coluna)
			{
				if($coluna['extra'] != 'auto_increment')
				{
					if($coluna['tipo'] == "tinyint" || $coluna['tipo'] == "smallint" || $coluna['tipo'] == "mediumint"
								|| $coluna['tipo'] == "int" || $coluna['tipo'] == "bigint" || $coluna['tipo'] == "decimal"
								|| $coluna['tipo'] == "float" || $coluna['tipo'] == "double" || $coluna['tipo'] == "bit")
					{
						$array_doc["alterar_" . strtolower($tabela)]['campo_corpo']['dados'][$coluna['nome_coluna']] = 0;
						$html_recebendo_campos .= "\$" . $coluna['nome_coluna'] . " = isset(\$dados['" . $coluna['nome_coluna'] . "']) && is_numeric(\$dados['" . $coluna['nome_coluna'] . "']) ? \$dados['" . $coluna['nome_coluna'] . "'] : NULL; ";
					}
					else
					{
						$array_doc["alterar_" . strtolower($tabela)]['campo_corpo']['dados'][$coluna['nome_coluna']] = "";
						$html_recebendo_campos .= "\$" . $coluna['nome_coluna'] . " = !empty(\$dados['" . $coluna['nome_coluna'] . "']) ? \$dados['" . $coluna['nome_coluna'] . "'] : NULL; ";
					}

					if(!empty($html_campos))
					{
						$html_campos .= "if(!is_null(\$" . $coluna['nome_coluna'] . ")) {";
						$html_campos .= 	"\$query .= ', " . $coluna['nome_coluna'] . " = \"' . \$" . $coluna['nome_coluna'] . " . '\"';";
						$html_campos .= "}";
					}
					else
					{
						$html_campos .= "if(!is_null(\$" . $coluna['nome_coluna'] . ")) {";
						$html_campos .= 	"\$query .= '" . $coluna['nome_coluna'] . " = \"' . \$" . $coluna['nome_coluna'] . " . '\"';";
						$html_campos .= "}";
					}
				}
				else
				{
					if($coluna['chave'] == 'PRI')
					{
						$array_doc["alterar_" . strtolower($tabela)]['campo_corpo']['dados'][$coluna['nome_coluna']] = 0;
						$array_doc["alterar_" . strtolower($tabela)]['campos_obrigatorios'][] = $coluna['nome_coluna'];
						$pks[] = $coluna;
					}
				}
			}

			$html_where = "";
			foreach($pks as $pk)
			{
				if(!empty($html_where))
				{
					$html_where .= " . ' AND " . $pk['nome_coluna'] . " = ' . \$" . $pk['nome_coluna'];
				}
				else
				{
					$html_where .= $pk['nome_coluna'] . " = \" .\$" . $pk['nome_coluna'];
				}

				if($pk['tipo'] == "tinyint" || $pk['tipo'] == "smallint" || $pk['tipo'] == "mediumint"
								|| $pk['tipo'] == "int" || $pk['tipo'] == "bigint" || $pk['tipo'] == "decimal"
								|| $pk['tipo'] == "float" || $pk['tipo'] == "double" || $pk['tipo'] == "bit")
				{
					$html_recebendo_campos .= "\$" . $pk['nome_coluna'] . " = validaCampo(\$dados, '" . $pk['nome_coluna'] . "', 400, 1); ";
				}
				else
				{
					$html_recebendo_campos .= "\$" . $pk['nome_coluna'] . " = validaCampo(\$dados, '" . $pk['nome_coluna'] . "', 400, 0); ";
				}
			}

			$qtd_funcoes++;
			$html_funcoes .= "function alterar_" . strtolower($tabela) . "(\$dados) { ";

			$html_funcoes .= " \$curdir = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR;";

			$html_funcoes .= "require_once(\$curdir . '../../functions/connection.php');";
			$html_funcoes .= "require_once(\$curdir . '../../functions/functions_basics.php');";

			$html_funcoes .= "\$conn_cliente = $conn_cliente;";

			$html_funcoes .= $html_recebendo_campos;

			$html_funcoes .= "\$query = 'UPDATE $tabela SET ';";

			$html_funcoes .= $html_campos;
			$html_funcoes .= "\$query .= \" WHERE $html_where;";

			$html_funcoes .= "\$result = mysqli_query(\$conn_cliente, \$query);";

			$html_funcoes .= "if(\$result !== FALSE)
							{
								\$ret = Array();
								\$ret['http_response_code'] = 200;
								\$ret['id'] = mysqli_insert_id(\$conn_cliente);
								\$ret['mensagem'] = '$tabela alterado(a) com sucesso.';
								printClientData(\$ret);
								exit();
							
							}
							else
							{
								\$ret = Array();
								\$ret['http_response_code'] = 400;
								\$ret['mensagem'] = 'Erro ao alterar $tabela.';
								printClientData(\$ret);
								exit();
							}";

			$html_funcoes .= "} ";
		}
	}

	if($cliente['clientes_habilita_delete'] == 1)
	{
		foreach($tabelas as $tabela)
		{
			$html_recebendo_campos = "";
			$html_campos = "";
			$html_where = "";
			$pks = Array();

			$array_doc["deletar_" . strtolower($tabela)]['cor'] = "#dc3545";
			$array_doc["deletar_" . strtolower($tabela)]['nome_funcao'] = "deletar_" . strtolower($tabela);
			$array_doc["deletar_" . strtolower($tabela)]['campos_obrigatorios'][] = 'autenticacao';
			$array_doc["deletar_" . strtolower($tabela)]['campos_obrigatorios'][] = 'acao';

			$array_doc["deletar_" . strtolower($tabela)]['campo_corpo']['autenticacao']['usuario'] = '';
			$array_doc["deletar_" . strtolower($tabela)]['campo_corpo']['autenticacao']['token'] = '';
			$array_doc["deletar_" . strtolower($tabela)]['campo_corpo']['acao'] = "deletar_" . strtolower($tabela);

			foreach($colunas[$tabela] as $key => $coluna)
			{
				if($coluna['extra'] == 'auto_increment')
				{
					if($coluna['chave'] == 'PRI')
					{
						$array_doc["deletar_" . strtolower($tabela)]['campos_obrigatorios'][] = $coluna['nome_coluna'];
						if($coluna['tipo'] == "tinyint" || $coluna['tipo'] == "smallint" || $coluna['tipo'] == "mediumint"
								|| $coluna['tipo'] == "int" || $coluna['tipo'] == "bigint" || $coluna['tipo'] == "decimal"
								|| $coluna['tipo'] == "float" || $coluna['tipo'] == "double" || $coluna['tipo'] == "bit")
						{
							$array_doc["deletar_" . strtolower($tabela)]['campo_corpo'][$coluna['nome_coluna']] = 0;
							$html_recebendo_campos .= "\$" . $coluna['nome_coluna'] . " = validaCampo(\$dados, '" . $coluna['nome_coluna'] . "', 400, 1); ";
						}
						else
						{
							$array_doc["deletar_" . strtolower($tabela)]['campo_corpo'][$coluna['nome_coluna']] = "";
							$html_recebendo_campos .= "\$" . $coluna['nome_coluna'] . " = validaCampo(\$dados, '" . $coluna['nome_coluna'] . "', 400, 0); ";
						}

						if(!empty($html_where))
						{
							$html_where .= " . ' AND " . $coluna['nome_coluna'] . " = ' . \$" . $coluna['nome_coluna'];
						}
						else
						{
							$html_where .= $coluna['nome_coluna'] . " = \" .\$" . $coluna['nome_coluna'];
						}
					}
				}
			}

			$qtd_funcoes++;
			$html_funcoes .= "function deletar_" . strtolower($tabela) . "(\$dados) { ";

			$html_funcoes .= " \$curdir = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR;";

			$html_funcoes .= "require_once(\$curdir . '../../functions/connection.php');";
			$html_funcoes .= "require_once(\$curdir . '../../functions/functions_basics.php');";

			$html_funcoes .= "\$conn_cliente = $conn_cliente;";

			$html_funcoes .= $html_recebendo_campos;

			$html_funcoes .= "\$query = 'DELETE FROM $tabela ';";

			$html_funcoes .= $html_campos;
			$html_funcoes .= "\$query .= \" WHERE $html_where;";

			$html_funcoes .= "\$result = mysqli_query(\$conn_cliente, \$query);";

			$html_funcoes .= "if(\$result !== FALSE)
							{
								\$ret = Array();
								\$ret['http_response_code'] = 200;
								\$ret['id'] = mysqli_insert_id(\$conn_cliente);
								\$ret['mensagem'] = '$tabela deletado(a) com sucesso.';
								printClientData(\$ret);
								exit();
							
							}
							else
							{
								\$ret = Array();
								\$ret['http_response_code'] = 400;
								\$ret['mensagem'] = 'Erro ao deletar $tabela.';
								printClientData(\$ret);
								exit();
							}";

			$html_funcoes .= "} ";
		}
	}
	atualizaQuantidadeFuncoesCliente($conn, $cliente['clientes_id'], $qtd_funcoes);
	
	$myfile = fopen($curdir . "../clientes/" . $cliente['clientes_id'] . "/functions.php", "w");
	fwrite($myfile, $html_funcoes);
	fclose($myfile);

	echo "Arquivo de funções criado do cliente: " . $cliente['clientes_nome'] . " (" . $cliente['clientes_id'] . ")\n";

	$i = 0;
	foreach ($array_doc as $doc) {
		$html_doc = '';
		$class = "box-1-2-2-decorado";
		if ($i % 2 == 0)
			$class = "box-1-2-1-decorado";

		$html_doc .= '<div class="' . $class . '" style="border-right: 10px solid ' . $doc['cor'] . ' !important;">
						<h5><span class="dash_right" style="color: ' . $doc['cor'] . ' !important;">' . $doc['nome_funcao'] . '</span><i class="bx bxs-down-arrow-alt exibir_doc cor_doc_' . $i . '" data-funcao="' . $doc['nome_funcao'] . '" style="color: #fff; float: right;font-size: 30px;"></i></h5>
						<div class="div_funcao ' . $doc['nome_funcao'] . '">
							<br>
							<p style="text-align: left"> Exemplo de corpo: <br> <span class="dash_right" style="font-size: 11px; color: ' . $doc['cor'] . ' !important;"> Campos obrigatórios: </span><span style="font-size: 11px;">' . implode(" | ", $doc['campos_obrigatorios']) . '</span></p>
							<div class="corpo_funcao">' . prettyPrint(json_encode($doc['campo_corpo'])) . '</div>
						</div>
					</div>
					<style>
					.cor_doc_' . $i . ':hover {
						color: ' . $doc['cor'] . ' !important;
					}
					</style>';
		$i++;
		insereDocCliente($conn, $cliente['clientes_id'], $html_doc);
	}

	return true;
}