<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';


$stmt = $conn->prepare("INSERT INTO subfuncao(funcao_id, nome) values(:funcao_id, :nome)");

$stmt->bindParam(':funcao_id', $_POST['funcao_id']);
$stmt->bindParam(':nome', $_POST['nome']);

try
{
	$stmt->execute();
	$_SESSION['msg'] = "Nova Subfunção cadastrada com sucesso";

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

	$stmt->execute();

	header("Location: ../../pages/subfuncao/listar.php");
}
catch(PDOException $e)
{
	$_SESSION['erro'] = "Erro: " . $e->getMessage();
}

?>