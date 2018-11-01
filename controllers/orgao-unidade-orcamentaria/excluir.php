<?php
session_start();
include '../../utils/bd.php';

$orgao_id    = $_GET['orgao'];
$unidade_orcamentaria_id = $_GET['unidade'];

$stmt = $conn->prepare("DELETE FROM orgao_has_unidade_orcamentaria 
                            WHERE orgao_id  = $orgao_id
                            AND unidade_orcamentaria_id = $unidade_orcamentaria_id");

try
{
	$stmt->execute();
	$_SESSION['msg'] = "Unidade Orçamentária desvinculada do Orgão com sucesso";
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

	header("Location: ../../pages/orgao-unidade-orcamentaria/novo.php?id=$orgao_id");
}
catch(PDOException $e)
{
	$_SESSION['erro'] = "Erro: " . $e->getMessage();
}

?>