<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

$stmt = $conn->prepare("INSERT INTO programa_has_fonte_recurso(programa_id, 
							fonte_recurso_id, valor) 
values(:programa_id, :fonte_recurso_id, :valor)");

$valor = str_replace(',','.', str_replace('.','', $_POST['valor']));
$programa_id = $_POST['programa'];

$stmt->bindParam(':programa_id', $programa_id);
$stmt->bindParam(':fonte_recurso_id', $_POST['fonte']);
$stmt->bindParam(':valor', $valor);

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

	header("Location: ../../pages/programa-recurso/listar.php?programa=$programa_id");
}
catch(PDOException $e)
{
	$_SESSION['erro'] = "Erro: " . $e->getMessage();
}

?>