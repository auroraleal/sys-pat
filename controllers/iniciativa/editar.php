<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

$stmt = $conn->prepare("UPDATE pat SET nome = :nome, programa_id = :programa_id, 
orgao_id = :orgao_id, secretaria_id = :secretaria_id, valor_global = :valor_global, 
inicio = :inicio,
 WHERE id = :id ");

$id = $_POST['id'];

$inicio = DateTime::createFromFormat('d/m/Y', $_POST['inicio'])->format('Y-m-d');
$termino = DateTime::createFromFormat('d/m/Y', $_POST['termino'])->format('Y-m-d');
$valor_global = str_replace(',','.', str_replace('.','', $_POST['valor_global']));
$valor_repasse = str_replace(',','.', str_replace('.','', $_POST['valor_repasse']));
$valor_contrapartida = str_replace(',','.', str_replace('.','', $_POST['valor_contrapartida']));

$stmt->bindParam(':nome', $_POST['nome']);
$stmt->bindParam(':programa', $_POST['programa_id']);
$stmt->bindParam(':funcao', $_POST['funcao_id']);
$stmt->bindParam(':resultado_esperado', $_POST['resultado_esperado_id']);
$stmt->bindParam(':objetivos_id', $_POST['objetivos_id']);
$stmt->bindParam(':iniciativa_id',  $_POST['iniciativa_id']);
$stmt->bindParam(':subfuncao_id',  $_POST['subfuncao_id']);

try
{
	$stmt->execute();
	$_SESSION['msg'] = "Convenio editado com sucesso";

	// LOG
	// --------
	$usuario_id = $_SESSION['id'];
	$operpat = 'EDITAR';
	$registro = json_encode($_POST);
	$data_operpat = date("Y-m-d H:i:s");
	$tipo_registro = 'CONVENIO';

	$stmt = $conn->prepare("INSERT INTO log(usuario_id, operpat, registro,tipo_registro, data_operpat) 
	values(:usuario_id, :operpat, :registro, :tipo_registro, :data_operpat)");


	$stmt->bindParam(':usuario_id', $usuario_id);
	$stmt->bindParam(':operpat', $operpat);
	$stmt->bindParam(':data_operpat', $data_operpat);
	$stmt->bindParam(':registro', $registro);
	$stmt->bindParam(':tipo_registro', $tipo_registro);

	$stmt->execute();

	header("Location: ../../pages/acoes/visualizar.php?id=$id");
}
catch(PDOException $e)
{
	$_SESSION['erro'] = "Erro: " . $e->getMessage();
}

?>