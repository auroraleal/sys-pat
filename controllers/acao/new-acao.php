<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

if (isset($_SESSION['perfil'])){
	$perfil = $_SESSION ['perfil'];
}

$stmt = $conn->prepare("INSERT INTO acao (nome, programa_id, orgao_id, funcao_id, subfuncao_id,
 resultado, ano, objetivo, periodo_inicio, periodo_fim, quantidade_iniciativas) 
values(:nome, :programa_id, :orgao_id, :funcao_id, :subfuncao_id, :resultado, :ano, :objetivo, 
:periodo_inicio, :periodo_fim,  :quantidade_iniciativas)");

// Não precisa mais converter. Já está sendo usado o calendário do HTML
//$inicio = DateTime::createFromFormat('d/m/Y', $_POST['periodo_inicio'])->format('Y-m-d');
//$fim = DateTime::createFromFormat('d/m/Y', $_POST['periodo_fim'])->format('Y-m-d');

//$valor_global = str_replace(',','.', str_replace('.','', $_POST['recurso']));
$stmt->bindParam(':nome',  $_POST['nome']);
$stmt->bindParam(':programa_id', $_POST['programa']);
$stmt->bindParam(':orgao_id', $_POST['orgao']);
$stmt->bindParam(':funcao_id', $_POST['funcao']);
$stmt->bindParam(':subfuncao_id',  $_POST['subfuncao']);
$stmt->bindParam(':resultado', $_POST['resultado']);
$stmt->bindParam(':ano',  $_POST['ano']);
$stmt->bindParam(':objetivo',  $_POST['objetivo']);
$stmt->bindParam(':periodo_inicio',  $_POST['periodo_inicio']);
$stmt->bindParam(':periodo_fim',  $_POST['periodo_fim']);
$stmt->bindParam(':quantidade_iniciativas',  $_POST['quantidade_iniciativas']);

try
{
	$stmt->execute();
	$_SESSION['msg'] = "Ação cadastrada com sucesso";

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