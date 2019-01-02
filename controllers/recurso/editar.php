<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

$stmt = $conn->prepare("UPDATE fonte_recurso SET nome = :nome, valor = :valor WHERE id = :id ");

$id = $_POST['id'];
$valor = str_replace(',','.', str_replace('.','', $_POST['valor']));

$stmt->bindParam(':nome', $_POST['nome']);
$stmt->bindParam(':valor', $valor);
$stmt->bindParam(':id', $id);

try
{
	$stmt->execute();
	$_SESSION['msg'] = "Recurso editado com sucesso";
/*
	$usuario_id = $_SESSION['id'];
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

	header("Location: ../../pages/recurso/listar.php?id=$id");
}
catch(PDOException $e)
{
	$_SESSION['erro'] = "Erro: " . $e->getMessage();
}

?>