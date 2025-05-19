<?php function listar_clientes($dados) {  $curdir = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR;require_once($curdir . '../../functions/connection.php');require_once($curdir . '../../functions/functions_basics.php');$conn_cliente = conectaDB('genrest.cwyf2g7tqmmw.sa-east-1.rds.amazonaws.com', 'admin', '123456789', 'genrest_cliente');$clientes_faixa_minimo = isset($dados['clientes_faixa_minimo']) && is_numeric($dados['clientes_faixa_minimo']) ? $dados['clientes_faixa_minimo'] : NULL; $clientes_id = isset($dados['clientes_id']) && is_numeric($dados['clientes_id']) ? $dados['clientes_id'] : NULL; $clientes_nome = !empty($dados['clientes_nome']) ? $dados['clientes_nome'] : NULL; $clientes_ramais = isset($dados['clientes_ramais']) && is_numeric($dados['clientes_ramais']) ? $dados['clientes_ramais'] : NULL; $clientes_sala_conf_minimo = isset($dados['clientes_sala_conf_minimo']) && is_numeric($dados['clientes_sala_conf_minimo']) ? $dados['clientes_sala_conf_minimo'] : NULL; $clientes_sala_conf_num_max = isset($dados['clientes_sala_conf_num_max']) && is_numeric($dados['clientes_sala_conf_num_max']) ? $dados['clientes_sala_conf_num_max'] : NULL; $clientes_faixa_maximo = isset($dados['clientes_faixa_maximo']) && is_numeric($dados['clientes_faixa_maximo']) ? $dados['clientes_faixa_maximo'] : NULL; $registro_inicial = validaCampo($dados, 'registro_inicial', 400, 1); $quantidade_limite = validaCampo($dados, 'quantidade_limite', 400, 1); $query = 'SELECT * FROM clientes WHERE 1 = 1 ';if(!is_null($clientes_faixa_minimo)) { $query .= ' AND clientes_faixa_minimo = "' . $clientes_faixa_minimo . '"';} if(!is_null($clientes_id)) { $query .= ' AND clientes_id = "' . $clientes_id . '"';} if(!is_null($clientes_nome)) { $query .= ' AND clientes_nome = "' . $clientes_nome . '"';} if(!is_null($clientes_ramais)) { $query .= ' AND clientes_ramais = "' . $clientes_ramais . '"';} if(!is_null($clientes_sala_conf_minimo)) { $query .= ' AND clientes_sala_conf_minimo = "' . $clientes_sala_conf_minimo . '"';} if(!is_null($clientes_sala_conf_num_max)) { $query .= ' AND clientes_sala_conf_num_max = "' . $clientes_sala_conf_num_max . '"';} if(!is_null($clientes_faixa_maximo)) { $query .= ' AND clientes_faixa_maximo = "' . $clientes_faixa_maximo . '"';} $query .= " LIMIT $registro_inicial, $quantidade_limite ";$result = mysqli_query($conn_cliente, $query);if($result !== FALSE)
						{
							$dados_db = mysqli_fetch_all_mod($result, MYSQLI_ASSOC);
							$ret_dados = Array();
							if(!empty($dados_db) && is_array($dados_db))
							{
								foreach($dados_db as $dado_db)
								{
									$ret_dado = Array();
									$ret_dado['clientes_faixa_minimo'] = $dado_db['clientes_faixa_minimo'];
			$ret_dado['clientes_id'] = $dado_db['clientes_id'];
			$ret_dado['clientes_nome'] = $dado_db['clientes_nome'];
			$ret_dado['clientes_ramais'] = $dado_db['clientes_ramais'];
			$ret_dado['clientes_sala_conf_minimo'] = $dado_db['clientes_sala_conf_minimo'];
			$ret_dado['clientes_sala_conf_num_max'] = $dado_db['clientes_sala_conf_num_max'];
			$ret_dado['clientes_faixa_maximo'] = $dado_db['clientes_faixa_maximo'];
			

									$ret_dados[] = $ret_dado;
								}
							}
							
							$ret = Array();
							$ret['http_response_code'] 		= 200;
							$ret['qtd_total_resultados'] 		= count($ret_dados);
							$ret['dados'] 						= $ret_dados;
							$ret['mensagem'] 					= '';
							printClientData($ret);
							die();}
						else
						{
							http_response_code(500);
							echo json_encode(array('http_response_code' => 500, 'mensagem' => 'Erro Interno'));
						}} function listar_usuarios($dados) {  $curdir = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR;require_once($curdir . '../../functions/connection.php');require_once($curdir . '../../functions/functions_basics.php');$conn_cliente = conectaDB('genrest.cwyf2g7tqmmw.sa-east-1.rds.amazonaws.com', 'admin', '123456789', 'genrest_cliente');$usuarios_tipo = isset($dados['usuarios_tipo']) && is_numeric($dados['usuarios_tipo']) ? $dados['usuarios_tipo'] : NULL; $usuarios_status = isset($dados['usuarios_status']) && is_numeric($dados['usuarios_status']) ? $dados['usuarios_status'] : NULL; $usuarios_senha = !empty($dados['usuarios_senha']) ? $dados['usuarios_senha'] : NULL; $usuarios_qtd_tentativas_login = isset($dados['usuarios_qtd_tentativas_login']) && is_numeric($dados['usuarios_qtd_tentativas_login']) ? $dados['usuarios_qtd_tentativas_login'] : NULL; $usuarios_perfil = isset($dados['usuarios_perfil']) && is_numeric($dados['usuarios_perfil']) ? $dados['usuarios_perfil'] : NULL; $usuarios_oculto = isset($dados['usuarios_oculto']) && is_numeric($dados['usuarios_oculto']) ? $dados['usuarios_oculto'] : NULL; $usuarios_login = !empty($dados['usuarios_login']) ? $dados['usuarios_login'] : NULL; $usuarios_id = isset($dados['usuarios_id']) && is_numeric($dados['usuarios_id']) ? $dados['usuarios_id'] : NULL; $usuarios_email = !empty($dados['usuarios_email']) ? $dados['usuarios_email'] : NULL; $usuarios_config = !empty($dados['usuarios_config']) ? $dados['usuarios_config'] : NULL; $usuarios_cliente_id = isset($dados['usuarios_cliente_id']) && is_numeric($dados['usuarios_cliente_id']) ? $dados['usuarios_cliente_id'] : NULL; $usuarios_bloqueio = isset($dados['usuarios_bloqueio']) && is_numeric($dados['usuarios_bloqueio']) ? $dados['usuarios_bloqueio'] : NULL; $usuarios_acesso = isset($dados['usuarios_acesso']) && is_numeric($dados['usuarios_acesso']) ? $dados['usuarios_acesso'] : NULL; $registro_inicial = validaCampo($dados, 'registro_inicial', 400, 1); $quantidade_limite = validaCampo($dados, 'quantidade_limite', 400, 1); $query = 'SELECT * FROM usuarios WHERE 1 = 1 ';if(!is_null($usuarios_tipo)) { $query .= ' AND usuarios_tipo = "' . $usuarios_tipo . '"';} if(!is_null($usuarios_status)) { $query .= ' AND usuarios_status = "' . $usuarios_status . '"';} if(!is_null($usuarios_senha)) { $query .= ' AND usuarios_senha = "' . $usuarios_senha . '"';} if(!is_null($usuarios_qtd_tentativas_login)) { $query .= ' AND usuarios_qtd_tentativas_login = "' . $usuarios_qtd_tentativas_login . '"';} if(!is_null($usuarios_perfil)) { $query .= ' AND usuarios_perfil = "' . $usuarios_perfil . '"';} if(!is_null($usuarios_oculto)) { $query .= ' AND usuarios_oculto = "' . $usuarios_oculto . '"';} if(!is_null($usuarios_login)) { $query .= ' AND usuarios_login = "' . $usuarios_login . '"';} if(!is_null($usuarios_id)) { $query .= ' AND usuarios_id = "' . $usuarios_id . '"';} if(!is_null($usuarios_email)) { $query .= ' AND usuarios_email = "' . $usuarios_email . '"';} if(!is_null($usuarios_config)) { $query .= ' AND usuarios_config = "' . $usuarios_config . '"';} if(!is_null($usuarios_cliente_id)) { $query .= ' AND usuarios_cliente_id = "' . $usuarios_cliente_id . '"';} if(!is_null($usuarios_bloqueio)) { $query .= ' AND usuarios_bloqueio = "' . $usuarios_bloqueio . '"';} if(!is_null($usuarios_acesso)) { $query .= ' AND usuarios_acesso = "' . $usuarios_acesso . '"';} $query .= " LIMIT $registro_inicial, $quantidade_limite ";$result = mysqli_query($conn_cliente, $query);if($result !== FALSE)
						{
							$dados_db = mysqli_fetch_all_mod($result, MYSQLI_ASSOC);
							$ret_dados = Array();
							if(!empty($dados_db) && is_array($dados_db))
							{
								foreach($dados_db as $dado_db)
								{
									$ret_dado = Array();
									$ret_dado['usuarios_tipo'] = $dado_db['usuarios_tipo'];
			$ret_dado['usuarios_status'] = $dado_db['usuarios_status'];
			$ret_dado['usuarios_senha'] = $dado_db['usuarios_senha'];
			$ret_dado['usuarios_qtd_tentativas_login'] = $dado_db['usuarios_qtd_tentativas_login'];
			$ret_dado['usuarios_perfil'] = $dado_db['usuarios_perfil'];
			$ret_dado['usuarios_oculto'] = $dado_db['usuarios_oculto'];
			$ret_dado['usuarios_login'] = $dado_db['usuarios_login'];
			$ret_dado['usuarios_id'] = $dado_db['usuarios_id'];
			$ret_dado['usuarios_email'] = $dado_db['usuarios_email'];
			$ret_dado['usuarios_config'] = $dado_db['usuarios_config'];
			$ret_dado['usuarios_cliente_id'] = $dado_db['usuarios_cliente_id'];
			$ret_dado['usuarios_bloqueio'] = $dado_db['usuarios_bloqueio'];
			$ret_dado['usuarios_acesso'] = $dado_db['usuarios_acesso'];
			

									$ret_dados[] = $ret_dado;
								}
							}
							
							$ret = Array();
							$ret['http_response_code'] 		= 200;
							$ret['qtd_total_resultados'] 		= count($ret_dados);
							$ret['dados'] 						= $ret_dados;
							$ret['mensagem'] 					= '';
							printClientData($ret);
							die();}
						else
						{
							http_response_code(500);
							echo json_encode(array('http_response_code' => 500, 'mensagem' => 'Erro Interno'));
						}} function inserir_clientes($dados) {  $curdir = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR;require_once($curdir . '../../functions/connection.php');require_once($curdir . '../../functions/functions_basics.php');$conn_cliente = conectaDB('genrest.cwyf2g7tqmmw.sa-east-1.rds.amazonaws.com', 'admin', '123456789', 'genrest_cliente');$clientes_faixa_minimo = isset($dados['clientes_faixa_minimo']) && is_numeric($dados['clientes_faixa_minimo']) ? $dados['clientes_faixa_minimo'] : NULL; $clientes_nome = !empty($dados['clientes_nome']) ? $dados['clientes_nome'] : NULL; $clientes_ramais = validaCampo($dados, 'clientes_ramais', 400, 1); $clientes_sala_conf_minimo = validaCampo($dados, 'clientes_sala_conf_minimo', 400, 1); $clientes_sala_conf_num_max = validaCampo($dados, 'clientes_sala_conf_num_max', 400, 1); $clientes_faixa_maximo = isset($dados['clientes_faixa_maximo']) && is_numeric($dados['clientes_faixa_maximo']) ? $dados['clientes_faixa_maximo'] : NULL; $query = 'INSERT INTO clientes (clientes_faixa_minimo,clientes_nome,clientes_ramais,clientes_sala_conf_minimo,clientes_sala_conf_num_max,clientes_faixa_maximo) VALUES ("' . $dados['clientes_faixa_minimo'] . '","' . $dados['clientes_nome'] . '","' . $dados['clientes_ramais'] . '","' . $dados['clientes_sala_conf_minimo'] . '","' . $dados['clientes_sala_conf_num_max'] . '","' . $dados['clientes_faixa_maximo'] . '");';$result = mysqli_query($conn_cliente, $query);if($result !== FALSE)
							{
								$ret = Array();
								$ret['http_response_code'] = 200;
								$ret['id'] = mysqli_insert_id($conn_cliente);
								$ret['mensagem'] = 'clientes cadastrado com sucesso.';
								printClientData($ret);
								exit();
							
							}
							else
							{
								$ret = Array();
								$ret['http_response_code'] = 400;
								$ret['mensagem'] = 'Erro ao inserir clientes.';
								printClientData($ret);
								exit();
							}} function inserir_usuarios($dados) {  $curdir = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR;require_once($curdir . '../../functions/connection.php');require_once($curdir . '../../functions/functions_basics.php');$conn_cliente = conectaDB('genrest.cwyf2g7tqmmw.sa-east-1.rds.amazonaws.com', 'admin', '123456789', 'genrest_cliente');$usuarios_tipo = isset($dados['usuarios_tipo']) && is_numeric($dados['usuarios_tipo']) ? $dados['usuarios_tipo'] : NULL; $usuarios_status = isset($dados['usuarios_status']) && is_numeric($dados['usuarios_status']) ? $dados['usuarios_status'] : NULL; $usuarios_senha = !empty($dados['usuarios_senha']) ? $dados['usuarios_senha'] : NULL; $usuarios_qtd_tentativas_login = validaCampo($dados, 'usuarios_qtd_tentativas_login', 400, 1); $usuarios_perfil = validaCampo($dados, 'usuarios_perfil', 400, 1); $usuarios_oculto = validaCampo($dados, 'usuarios_oculto', 400, 1); $usuarios_login = validaCampo($dados, 'usuarios_login', 400, 0); $usuarios_email = !empty($dados['usuarios_email']) ? $dados['usuarios_email'] : NULL; $usuarios_config = !empty($dados['usuarios_config']) ? $dados['usuarios_config'] : NULL; $usuarios_cliente_id = validaCampo($dados, 'usuarios_cliente_id', 400, 1); $usuarios_bloqueio = validaCampo($dados, 'usuarios_bloqueio', 400, 1); $usuarios_acesso = validaCampo($dados, 'usuarios_acesso', 400, 1); $query = 'INSERT INTO usuarios (usuarios_tipo,usuarios_status,usuarios_senha,usuarios_qtd_tentativas_login,usuarios_perfil,usuarios_oculto,usuarios_login,usuarios_email,usuarios_config,usuarios_cliente_id,usuarios_bloqueio,usuarios_acesso) VALUES ("' . $dados['usuarios_tipo'] . '","' . $dados['usuarios_status'] . '","' . $dados['usuarios_senha'] . '","' . $dados['usuarios_qtd_tentativas_login'] . '","' . $dados['usuarios_perfil'] . '","' . $dados['usuarios_oculto'] . '","' . $dados['usuarios_login'] . '","' . $dados['usuarios_email'] . '","' . $dados['usuarios_config'] . '","' . $dados['usuarios_cliente_id'] . '","' . $dados['usuarios_bloqueio'] . '","' . $dados['usuarios_acesso'] . '");';$result = mysqli_query($conn_cliente, $query);if($result !== FALSE)
							{
								$ret = Array();
								$ret['http_response_code'] = 200;
								$ret['id'] = mysqli_insert_id($conn_cliente);
								$ret['mensagem'] = 'usuarios cadastrado com sucesso.';
								printClientData($ret);
								exit();
							
							}
							else
							{
								$ret = Array();
								$ret['http_response_code'] = 400;
								$ret['mensagem'] = 'Erro ao inserir usuarios.';
								printClientData($ret);
								exit();
							}} function alterar_clientes($dados) {  $curdir = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR;require_once($curdir . '../../functions/connection.php');require_once($curdir . '../../functions/functions_basics.php');$conn_cliente = conectaDB('genrest.cwyf2g7tqmmw.sa-east-1.rds.amazonaws.com', 'admin', '123456789', 'genrest_cliente');$clientes_faixa_minimo = isset($dados['clientes_faixa_minimo']) && is_numeric($dados['clientes_faixa_minimo']) ? $dados['clientes_faixa_minimo'] : NULL; $clientes_nome = !empty($dados['clientes_nome']) ? $dados['clientes_nome'] : NULL; $clientes_ramais = isset($dados['clientes_ramais']) && is_numeric($dados['clientes_ramais']) ? $dados['clientes_ramais'] : NULL; $clientes_sala_conf_minimo = isset($dados['clientes_sala_conf_minimo']) && is_numeric($dados['clientes_sala_conf_minimo']) ? $dados['clientes_sala_conf_minimo'] : NULL; $clientes_sala_conf_num_max = isset($dados['clientes_sala_conf_num_max']) && is_numeric($dados['clientes_sala_conf_num_max']) ? $dados['clientes_sala_conf_num_max'] : NULL; $clientes_faixa_maximo = isset($dados['clientes_faixa_maximo']) && is_numeric($dados['clientes_faixa_maximo']) ? $dados['clientes_faixa_maximo'] : NULL; $clientes_id = validaCampo($dados, 'clientes_id', 400, 1); $query = 'UPDATE clientes SET ';if(!is_null($clientes_faixa_minimo)) {$query .= 'clientes_faixa_minimo = "' . $clientes_faixa_minimo . '"';}if(!is_null($clientes_nome)) {$query .= ', clientes_nome = "' . $clientes_nome . '"';}if(!is_null($clientes_ramais)) {$query .= ', clientes_ramais = "' . $clientes_ramais . '"';}if(!is_null($clientes_sala_conf_minimo)) {$query .= ', clientes_sala_conf_minimo = "' . $clientes_sala_conf_minimo . '"';}if(!is_null($clientes_sala_conf_num_max)) {$query .= ', clientes_sala_conf_num_max = "' . $clientes_sala_conf_num_max . '"';}if(!is_null($clientes_faixa_maximo)) {$query .= ', clientes_faixa_maximo = "' . $clientes_faixa_maximo . '"';}$query .= " WHERE clientes_id = " .$clientes_id;$result = mysqli_query($conn_cliente, $query);if($result !== FALSE)
							{
								$ret = Array();
								$ret['http_response_code'] = 200;
								$ret['id'] = mysqli_insert_id($conn_cliente);
								$ret['mensagem'] = 'clientes alterado(a) com sucesso.';
								printClientData($ret);
								exit();
							
							}
							else
							{
								$ret = Array();
								$ret['http_response_code'] = 400;
								$ret['mensagem'] = 'Erro ao alterar clientes.';
								printClientData($ret);
								exit();
							}} function alterar_usuarios($dados) {  $curdir = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR;require_once($curdir . '../../functions/connection.php');require_once($curdir . '../../functions/functions_basics.php');$conn_cliente = conectaDB('genrest.cwyf2g7tqmmw.sa-east-1.rds.amazonaws.com', 'admin', '123456789', 'genrest_cliente');$usuarios_tipo = isset($dados['usuarios_tipo']) && is_numeric($dados['usuarios_tipo']) ? $dados['usuarios_tipo'] : NULL; $usuarios_status = isset($dados['usuarios_status']) && is_numeric($dados['usuarios_status']) ? $dados['usuarios_status'] : NULL; $usuarios_senha = !empty($dados['usuarios_senha']) ? $dados['usuarios_senha'] : NULL; $usuarios_qtd_tentativas_login = isset($dados['usuarios_qtd_tentativas_login']) && is_numeric($dados['usuarios_qtd_tentativas_login']) ? $dados['usuarios_qtd_tentativas_login'] : NULL; $usuarios_perfil = isset($dados['usuarios_perfil']) && is_numeric($dados['usuarios_perfil']) ? $dados['usuarios_perfil'] : NULL; $usuarios_oculto = isset($dados['usuarios_oculto']) && is_numeric($dados['usuarios_oculto']) ? $dados['usuarios_oculto'] : NULL; $usuarios_login = !empty($dados['usuarios_login']) ? $dados['usuarios_login'] : NULL; $usuarios_email = !empty($dados['usuarios_email']) ? $dados['usuarios_email'] : NULL; $usuarios_config = !empty($dados['usuarios_config']) ? $dados['usuarios_config'] : NULL; $usuarios_cliente_id = isset($dados['usuarios_cliente_id']) && is_numeric($dados['usuarios_cliente_id']) ? $dados['usuarios_cliente_id'] : NULL; $usuarios_bloqueio = isset($dados['usuarios_bloqueio']) && is_numeric($dados['usuarios_bloqueio']) ? $dados['usuarios_bloqueio'] : NULL; $usuarios_acesso = isset($dados['usuarios_acesso']) && is_numeric($dados['usuarios_acesso']) ? $dados['usuarios_acesso'] : NULL; $usuarios_id = validaCampo($dados, 'usuarios_id', 400, 1); $query = 'UPDATE usuarios SET ';if(!is_null($usuarios_tipo)) {$query .= 'usuarios_tipo = "' . $usuarios_tipo . '"';}if(!is_null($usuarios_status)) {$query .= ', usuarios_status = "' . $usuarios_status . '"';}if(!is_null($usuarios_senha)) {$query .= ', usuarios_senha = "' . $usuarios_senha . '"';}if(!is_null($usuarios_qtd_tentativas_login)) {$query .= ', usuarios_qtd_tentativas_login = "' . $usuarios_qtd_tentativas_login . '"';}if(!is_null($usuarios_perfil)) {$query .= ', usuarios_perfil = "' . $usuarios_perfil . '"';}if(!is_null($usuarios_oculto)) {$query .= ', usuarios_oculto = "' . $usuarios_oculto . '"';}if(!is_null($usuarios_login)) {$query .= ', usuarios_login = "' . $usuarios_login . '"';}if(!is_null($usuarios_email)) {$query .= ', usuarios_email = "' . $usuarios_email . '"';}if(!is_null($usuarios_config)) {$query .= ', usuarios_config = "' . $usuarios_config . '"';}if(!is_null($usuarios_cliente_id)) {$query .= ', usuarios_cliente_id = "' . $usuarios_cliente_id . '"';}if(!is_null($usuarios_bloqueio)) {$query .= ', usuarios_bloqueio = "' . $usuarios_bloqueio . '"';}if(!is_null($usuarios_acesso)) {$query .= ', usuarios_acesso = "' . $usuarios_acesso . '"';}$query .= " WHERE usuarios_id = " .$usuarios_id;$result = mysqli_query($conn_cliente, $query);if($result !== FALSE)
							{
								$ret = Array();
								$ret['http_response_code'] = 200;
								$ret['id'] = mysqli_insert_id($conn_cliente);
								$ret['mensagem'] = 'usuarios alterado(a) com sucesso.';
								printClientData($ret);
								exit();
							
							}
							else
							{
								$ret = Array();
								$ret['http_response_code'] = 400;
								$ret['mensagem'] = 'Erro ao alterar usuarios.';
								printClientData($ret);
								exit();
							}} function deletar_clientes($dados) {  $curdir = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR;require_once($curdir . '../../functions/connection.php');require_once($curdir . '../../functions/functions_basics.php');$conn_cliente = conectaDB('genrest.cwyf2g7tqmmw.sa-east-1.rds.amazonaws.com', 'admin', '123456789', 'genrest_cliente');$clientes_id = validaCampo($dados, 'clientes_id', 400, 1); $query = 'DELETE FROM clientes ';$query .= " WHERE clientes_id = " .$clientes_id;$result = mysqli_query($conn_cliente, $query);if($result !== FALSE)
							{
								$ret = Array();
								$ret['http_response_code'] = 200;
								$ret['id'] = mysqli_insert_id($conn_cliente);
								$ret['mensagem'] = 'clientes deletado(a) com sucesso.';
								printClientData($ret);
								exit();
							
							}
							else
							{
								$ret = Array();
								$ret['http_response_code'] = 400;
								$ret['mensagem'] = 'Erro ao deletar clientes.';
								printClientData($ret);
								exit();
							}} function deletar_usuarios($dados) {  $curdir = dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR;require_once($curdir . '../../functions/connection.php');require_once($curdir . '../../functions/functions_basics.php');$conn_cliente = conectaDB('genrest.cwyf2g7tqmmw.sa-east-1.rds.amazonaws.com', 'admin', '123456789', 'genrest_cliente');$usuarios_id = validaCampo($dados, 'usuarios_id', 400, 1); $query = 'DELETE FROM usuarios ';$query .= " WHERE usuarios_id = " .$usuarios_id;$result = mysqli_query($conn_cliente, $query);if($result !== FALSE)
							{
								$ret = Array();
								$ret['http_response_code'] = 200;
								$ret['id'] = mysqli_insert_id($conn_cliente);
								$ret['mensagem'] = 'usuarios deletado(a) com sucesso.';
								printClientData($ret);
								exit();
							
							}
							else
							{
								$ret = Array();
								$ret['http_response_code'] = 400;
								$ret['mensagem'] = 'Erro ao deletar usuarios.';
								printClientData($ret);
								exit();
							}} 