<?php
session_start();
include '../../utils/bd.php';

$programa_id = $_GET['programa'];
$orgao_id    = $_GET['orgao'];

$stmt = $conn->prepare("DELETE FROM programa_has_orgao 
                            WHERE orgao_id  = $orgao_id
                            AND programa_id = $programa_id");

try
{
	$stmt->execute();
	$_SESSION['msg'] = "Programa desvinculado do Orgão com sucesso";
	/*$usuario_id = $_SESSION['id'];
	$operpat = 'EXCLUIR';
	$registro = json_encode($_POST);
	$tipo_registro = 'SECRETARIA';
	$data_operpat = date("Y-m-d H:i:s");

	$stmt = $conn->prepare("INSERT INTO log(usuario_id, operpat, registro, tipo_registro, data_operpat) 
	values(:usuario_id, :operpat, :registro, :tipo_registro, :data_operpat)");

	$stmt->bindParam(':usuario_id', $usuario_id);
	$stmt->bindParam(':operpat', $operpat);
	$stmt->bindParam(':data_operpat', $data_operpat);
	$stmt->bindParam(':registro', $registro);
	$stmt->bindParam(':tipo_registro', $tipo_registro);

	$stmt->execute();*/

	header("Location: ../../pages/orgao/listar.php");
}
catch(PDOException $e)
{
	$_SESSION['erro'] = "Erro: " . $e->getMessage();
}

?>