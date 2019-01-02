<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

$stmt = $conn->prepare("INSERT INTO acao_has_fonte_recurso(acao_id, 
							fonte_recurso_id) 
values(:acao_id, :fonte_recurso_id)");

$acao_id = $_POST['acao_id'];

$stmt->bindParam(':acao_id', $acao_id);
$stmt->bindParam(':fonte_recurso_id', $_POST['fonte']);

try
{
	$stmt->execute();
	$_SESSION['msg'] = "Nova alocação de recurso cadastrada com sucesso";
/*
	$usuario_id = $_SESSION['id'];
	$operpat = 'EDITAR';
	$registro = json_encode($_POST);
	$tipo_registro = 'TIPO CONVENIO';
	$data_operpat = date("Y-m-d H:i:s");

	$stmt = $conn->prepare("INSERT INTO log(usuario_id, operpat, registro, tipo_registro, data_operpat) 
	values(:usuario_id, :operpat, :registro, :tipo_registro, :data_operpat)");

	$stmt->bindParam(':usuario_id', $usuario_id);
	$stmt->bindParam(':operpat', $operpat);
	$stmt->bindParam(':data_operpat', $data_operpat);
	$stmt->bindParam(':registro', $registro);
	$stmt->bindParam(':tipo_registro', $tipo_registro);
*/
	$stmt->execute();

	header("Location: ../../pages/acao-recurso/listar.php?acao=$acao_id");
}
catch(PDOException $e)
{
	$_SESSION['erro'] = "Erro: " . $e->getMessage();
}

?>