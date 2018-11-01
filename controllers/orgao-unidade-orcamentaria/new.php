<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

$orgao = $_POST['orgao'];
$unidade_orcamentaria = $_POST['unidade_orcamentaria'];

$stmt = $conn->prepare("INSERT INTO orgao_has_unidade_orcamentaria (orgao_id, unidade_orcamentaria_id) 
							VALUES (:orgao_id, :unidade_orcamentaria_id)");

$stmt->bindParam(':orgao_id', $orgao);
$stmt->bindParam(':unidade_orcamentaria_id', $unidade_orcamentaria);

try
{
	$stmt->execute();
	$_SESSION['msg'] = "Unidade Orçamentária Vinculada ao Orgão com sucesso";

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
	
	header("Location: ../../pages/orgao-unidade-orcamentaria/novo.php?id=$orgao");
}
catch(PDOException $e)
{
	$_SESSION['erro'] = "Erro: " . $e->getMessage();
}
?>