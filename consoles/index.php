<?php
$curdir = dirname( realpath( __FILE__ ) ) . DIRECTORY_SEPARATOR;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: " . implode(", ", array("GET", "POST", "PUT", "DELETE")));
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Content-Type: application/json");

require_once($curdir . "functions/connection.php");
require_once($curdir . "functions/functions_basics.php");
require_once($curdir . "functions/functions_clientes.php");

//Valida se o method http recebido é um metodo validado
$ret = validaHttpMetodoRecebido();
if($ret["http_response_code"] != 200)
{
        printClientData($ret);
        exit;
}

session_start();

// Pega dados enviados pelo usuário
$http_dados_recebidos = getDadosHttpRecebidos();
if(empty($http_dados_recebidos))
{
        printClientData($http_dados_recebidos);
}

$conn = conectaDB();
$dados = $http_dados_recebidos['dados'];

$token_valido = retornaTokenValido($conn, $dados);

if(!$token_valido["validado"])
{
        printTokenInvalido();
        die();
}
else
{
        $cliente_id = $token_valido["cliente_id"];
        $usuario = $token_valido["usuario"];
}

if($cliente_id == 0)
{
        printTokenInvalido();
        die();
}

require_once($curdir . "clientes/" . $cliente_id . "/functions.php");

$acao = validaCampo($dados, "acao", 400, 0);

insereLog($conn, $cliente_id, json_encode($dados), $usuario);

switch ($ret["http_method"]) {
	case "GET":
	case "POST":
	case "PUT":
	case "DELETE":
		if (function_exists($acao)) {
			if (strpos($acao, "inser") !== false || strpos($acao, "alter") !== false)
				$acao($dados['dados']);
			else
				$acao($dados);
		} else {
			$dados["http_response_code"] = 400;
			$dados["mensagem"] = "Função não encontrada.";
			printClientData($dados);
			break;
		}
	default:
		$dados["http_response_code"] = 400;
		$dados["mensagem"] = "Method não encontrado.";
		printClientData($dados);
		break;
}

die();
