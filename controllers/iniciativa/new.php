<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

if (isset($_SESSION['perfil'])){
	$perfil = $_SESSION ['perfil'];
}

$acao_id = $_POST['acao_id'];

// VERIFICA SE JÁ EXISTE DOTAÇÃO CADASTRADA PARA A AÇÃO
$stmt_dotacao = $conn->prepare("SELECT * FROM dotacao_orcamentaria 
								WHERE acao_id = :acao_id;");
$stmt_dotacao->bindParam(':acao_id', $acao_id);
$stmt_dotacao->execute();
$rs_dotacao = $stmt_dotacao->fetchAll(PDO::FETCH_ASSOC);

if (empty($rs_dotacao)) {
	$query_dotacao = "INSERT INTO dotacao_orcamentaria (quadrimestre, valor_inicial,
						valor_atual, acao_id) 
				      VALUES(:quadrimestre, :valor_inicial,
						:valor_atual, :acao_id)";
} else {
	$query_dotacao = "UPDATE dotacao_orcamentaria 
						SET valor_inicial = :valor_inicial,
							valor_atual   = :valor_atual
				      WHERE acao_id = :acao_id 
						AND quadrimestre = :quadrimestre";
}

for ($i = 1; $i <= 3; $i++) {
	// ROTINA DE INSERÇÃO DA DOTAÇÃO ORÇAMENTÁRIA
	$valor_inicial = 'quad_' . $i .'_inicial';
	$valor_atual   = 'quad_' . $i .'_atual';

	$valor_inicial = str_replace(',','.', str_replace('.','', $_POST[$valor_inicial]));
	$valor_atual   = str_replace(',','.', str_replace('.','', $_POST[$valor_atual]));
	
	$stmt_dotacao_orcamentaria = $conn->prepare($query_dotacao);

	$quadrimestre = '';
	switch ($i) {
		case 1:
			$quadrimestre = "Primeiro";
			break;
		case 2:
			$quadrimestre = "Segundo";
			break;
		case 3:
			$quadrimestre = "Terceiro";
			break;
	}

	$stmt_dotacao_orcamentaria->bindParam(':quadrimestre', $quadrimestre);
	$stmt_dotacao_orcamentaria->bindParam(':valor_inicial', $valor_inicial);
	$stmt_dotacao_orcamentaria->bindParam(':valor_atual', $valor_atual);
	$stmt_dotacao_orcamentaria->bindParam(':acao_id', $acao_id);

	$stmt_dotacao_orcamentaria->execute();
}

// ---------------------------------------------------------------------------------------------

$quantidade_iniciativas = $_POST['quantidade_iniciativas'];
$metas_extras = $_POST['metas_extras'];
$justificativa = $_POST['justificativa_metas_n_exec'];

// VERIFICA SE JÁ EXISTE INICIATIVA CADASTRADA PARA A AÇÃO
$stmt_ini = $conn->prepare("SELECT * FROM iniciativa 
							WHERE acao_id = :acao_id;");
$stmt_ini->bindParam(':acao_id', $acao_id);
$stmt_ini->execute();
$rs_iniciativa = $stmt_ini->fetchAll(PDO::FETCH_ASSOC);

if (count($rs_iniciativa) == 0) {
	$operacao = 'INSERT';
	$query_iniciativa = "INSERT INTO iniciativa (descricao, acao_id,
										justificativa_nao_executadas,
										metas_extras) 
			  			 	VALUES(:descricao, :acao_id, 
							   :justificativa, :metas_extras)";
} else {
	$operacao = 'UPDATE';

	// ATUALIZA SOMENTE AS INICIATIVAS DA AÇÃO
	$query_iniciativa = "UPDATE iniciativa	 
						 	SET descricao = :descricao,
							 	justificativa_nao_executadas = :justificativa,
								metas_extras = :metas_extras
						 WHERE id = :iniciativa_id";
}

// BUSCA AS INICIATIVAS RELACIONADAS COM A AÇÃO EM QUESTÃO
$query_id_iniciativas = "SELECT id FROM pat.iniciativa where acao_id = :acao_id;";
$stmt_ini = $conn->prepare($query_id_iniciativas);
$stmt_ini->bindParam(':acao_id', $acao_id);
$stmt_ini->execute();

$ids = "";
while ($row = $stmt_ini->fetch(PDO::FETCH_ASSOC)) {
	$ids .= $row['id'] . ",";
}
$ids = substr($ids, 0, -1); // REMOVE A ULTIMA VIRGULA DOS IDS ENCONTRADOS
							// PARA EXECUTAR A QUERY SEM ERROS

if (strlen($ids) > 1) { // SE HOUVER MAIS DE UM ID...
	$iniciativas_id = explode(",", $ids); // ARRAY COM OS IDS DAS INICIATIVAS DA ACAO
} else {
	$iniciativas_id = array($ids);
}

// ROTINA DE INSERÇÃO DAS INICIATIVAS
for ($i = 1; $i <= $quantidade_iniciativas; $i++) { // i = CONTADOR DA INICIATIVA
	$stmt_iniciativa = $conn->prepare($query_iniciativa);
								
	$descricao = 'descricao_iniciativa' . $i;

	if (empty($_POST[$descricao])){
		$descricao = '-';
	} else {
		$descricao = $_POST[$descricao];
	}

	$stmt_iniciativa->bindParam(':descricao', $descricao);
	$stmt_iniciativa->bindParam(':justificativa', $justificativa);
	$stmt_iniciativa->bindParam(':metas_extras', $metas_extras);
	
	if ($operacao === 'INSERT') {
		$stmt_iniciativa->bindParam(':acao_id', $acao_id);
		$stmt_iniciativa->execute();
	} 

	if ($operacao === 'UPDATE') {
		$stmt_iniciativa->bindParam(':iniciativa_id', $iniciativas_id[$i - 1]);
		$stmt_iniciativa->execute();
	}
}

for ($i = 1; $i <= $quantidade_iniciativas; $i++) {
	// LIMPA AS METAS EXISTENTES PARA A INCIATIVA
	$stmt_clean_meta = $conn->prepare("DELETE FROM metas 
										WHERE iniciativa_id = :iniciativa_id");
	$stmt_clean_meta->bindParam(':iniciativa_id', $iniciativas_id[$i - 1]);
	$stmt_clean_meta->execute();
}

for ($i = 1; $i <= $quantidade_iniciativas; $i++) { // i = CONTADOR DA INICIATIVA
	for ($y = 1; $y <=3; $y++) { // y = CONTADOR PARA AS METAS DA INICIATIVA
		// DEPOIS INSERE OS REGISTROS COM OS VALORES ATUALIZADOS
		$quad_perc_plan = 'quad_perc_plan' . $i . $y;
		$quad_perc_exec = 'quad_perc_exec' . $i . $y;

		if (!empty($_POST[$quad_perc_plan]) && !empty($_POST[$quad_perc_exec])) {
			$quad_perc_plan = $_POST[$quad_perc_plan];
			$quad_perc_exec = $_POST[$quad_perc_exec];
		} else {
			$quad_perc_plan = 0;
			$quad_perc_exec = 0;
		}

		$stmt_meta = $conn->prepare("INSERT INTO metas (quadrimestre, percentual_planejado,
														percentual_executado, iniciativa_id) 
										VALUES(:quadrimestre, :percentual_planejado,
												:percentual_executado, :iniciativa_id)");
		$stmt_meta->bindParam(':quadrimestre', $y);
		$stmt_meta->bindParam(':percentual_planejado', $quad_perc_plan);
		$stmt_meta->bindParam(':percentual_executado', $quad_perc_exec);
		$stmt_meta->bindParam(':iniciativa_id', $iniciativas_id[$i - 1]);

		$stmt_meta->execute();
	}
}
	//-------------------------------
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