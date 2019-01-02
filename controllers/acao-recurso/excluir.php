<?php
session_start();
include '../../utils/bd.php';

$acao_id = $_GET['acao'];
$fonte_recurso_id = $_GET['fonte-recurso'];

$stmt = $conn->prepare("DELETE FROM acao_has_fonte_recurso 
						WHERE acao_id = :acao_id
						AND   fonte_recurso_id = :fonte_recurso_id");

$stmt->bindParam(':acao_id', $acao_id);
$stmt->bindParam(':fonte_recurso_id', $fonte_recurso_id);

try
{
	$stmt->execute();
	$_SESSION['msg'] = "Alocação de Recurso para a Ação excluída com sucesso";

	/*$usuario_id = $_SESSION['id'];
	$operpat = 'EDITAR';
	$registro = json_encode($_POST);
	$tipo_registro = 'PROGRAMA';
	$data_operpat = date("Y-m-d H:i:s");

	$stmt = $conn->prepare("INSERT INTO log(usuario_id, operpat, registro, tipo_registro, data_operpat) 
	values(:usuario_id, :operpat, :registro, :tipo_registro, :data_operpat)");

	$stmt->bindParam(':usuario_id', $usuario_id);
	$stmt->bindParam(':operpat', $operpat);
	$stmt->bindParam(':data_operpat', $data_operpat);
	$stmt->bindParam(':registro', $registro);
	$stmt->bindParam(':tipo_registro', $tipo_registro);

	$stmt->execute();*/

	header("Location: ../../pages/acao-recurso/listar.php?acao=$acao_id");
}
catch(PDOException $e)
{
	$_SESSION['erro'] = "Erro: " . $e->getMessage();
}

?>