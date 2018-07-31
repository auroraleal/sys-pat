<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

if (isset($_SESSION['perfil'])){
	$perfil = $_SESSION ['perfil'];
}

$acao_id = $_POST['acao_id'];
$quantidade_iniciativas = $_POST['quantidade_iniciativas'];

for ($i = 1; $i <= 3; $i++) {
	// ROTINA DE INSERÇÃO DA DOTAÇÃO ORÇAMENTÁRIA
	$valor_inicial = 'quad_' . $i .'_inicial';
	$valor_atual   = 'quad_' . $i .'_atual';

	$valor_inicial = str_replace(',','.', str_replace('.','', $_POST[$valor_inicial]));
	$valor_atual   = str_replace(',','.', str_replace('.','', $_POST[$valor_atual]));

	$stmt_dotacao_orcamentaria = $conn->prepare("INSERT INTO dotacao_orcamentaria (quadrimestre, valor_inicial,
																   valor_atual, acao_id) 
												   VALUES(:quadrimestre, :valor_inicial,
														:valor_atual, :acao_id)");
	$stmt_dotacao_orcamentaria->bindParam(':quadrimestre', $i);
	$stmt_dotacao_orcamentaria->bindParam(':valor_inicial', $valor_inicial);
	$stmt_dotacao_orcamentaria->bindParam(':valor_atual', $valor_atual);
	$stmt_dotacao_orcamentaria->bindParam(':acao_id', $acao_id);

	$stmt_dotacao_orcamentaria->execute();
}

for ($i = 1; $i <= $quantidade_iniciativas; $i++) {
	$stmt_iniciativa = $conn->prepare("INSERT INTO iniciativa (descricao, acao_id) 
							   VALUES(:descricao, :acao_id)");
							   
	$descricao = 'descricao_iniciativa' . $i;

	$stmt_iniciativa->bindParam(':descricao', $_POST[$descricao]);
	$stmt_iniciativa->bindParam(':acao_id', $acao_id);

	$stmt_iniciativa->execute();
	$iniciativa_id = $conn->lastInsertId();

	for ($y = 1; $y <= 3; $y++) {
		// ROTINA DE INSERÇÃO DAS METAS
		$quad_perc_plan = 'quad_perc_plan' . $i . $y;
		$quad_perc_exec = 'quad_perc_exec' . $i . $y;

		$quad_perc_plan = $_POST[$quad_perc_plan];
		$quad_perc_exec = $_POST[$quad_perc_exec];

		$stmt_meta = $conn->prepare("INSERT INTO metas (quadrimestre, percentual_planejado,
													   percentual_executado, iniciativa_id) 
										VALUES(:quadrimestre, :percentual_planejado,
											   :percentual_executado, :iniciativa_id)");
		$stmt_meta->bindParam(':quadrimestre', $y);
		$stmt_meta->bindParam(':percentual_planejado', $quad_perc_plan);
		$stmt_meta->bindParam(':percentual_executado', $quad_perc_exec);
		$stmt_meta->bindParam(':iniciativa_id', $iniciativa_id);

		$stmt_meta->execute();
	}
}

try
{
	$_SESSION['msg'] = "Iniciativa(s) cadastrada(s) com sucesso";

	// LOG
	// --------
	/*$usuario_id = $_SESSION['id'];
	$operpat = 'CADASTRAR';
	$registro = json_encode($_POST);
	$data_operpat = date("Y-m-d H:i:s");
	$tipo_registro = 'pat';

	$stmt = $conn->prepare("INSERT INTO log(usuario_id, operpat, registro, tipo_registro,
	data_operpat) 
	values(:usuario_id, :operpat, :registro, :tipo_registro, :data_operpat)");


	$stmt->bindParam(':usuario_id', $usuario_id);
	$stmt->bindParam(':operpat', $operpat);
	$stmt->bindParam(':data_operpat', $data_operpat);
	$stmt->bindParam(':registro', $registro);
	$stmt->bindParam(':tipo_registro', $tipo_registro);

	$stmt->execute();*/
	// ----------------
	header("Location: ../../pages/acao/listar.php");
}
catch(PDOException $e)
{
	$_SESSION['erro'] = "Erro: " . $e->getMessage();
}

?>