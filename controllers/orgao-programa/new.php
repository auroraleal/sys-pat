<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

$stmt = $conn->prepare("INSERT INTO programa_has_orgao (orgao_id, programa_id) VALUES (:orgao_id, :programa_id)");

$stmt->bindParam(':orgao_id', $_POST['orgao']);
$stmt->bindParam(':programa_id', $_POST['programa']);

try
{
	$stmt->execute();
	$_SESSION['msg'] = "Programa Vinculado ao Orgão com sucesso";

	/*$usuario_id = $_SESSION['id'];
	$operpat = 'CADASTRAR';
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