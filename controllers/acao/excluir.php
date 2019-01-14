<?php
session_start();
include '../../utils/bd.php';

$id = $_GET['acao'];

if (isset($_GET['ano'])) {
	$ano = $_GET['ano'];
} else {
	$ano = date('Y');
}

$stmt = $conn->prepare("DELETE FROM acao_has_fonte_recurso WHERE acao_id = $id");
$stmt->execute();
$stmt = $conn->prepare("DELETE FROM dotacao_orcamentaria WHERE acao_id = $id");
$stmt->execute();
$stmt = $conn->prepare("DELETE FROM metas WHERE iniciativa_id IN 
							(SELECT id FROM iniciativa WHERE acao_id = $id)");
$stmt->execute();
$stmt = $conn->prepare("DELETE FROM iniciativa WHERE acao_id = $id");
$stmt->execute();
$stmt = $conn->prepare("DELETE FROM acao WHERE id = $id");
$stmt->execute();

// LOG
// -----
/*$usuario_id = $_SESSION['id'];
$operpat = 'EXCLUIR';
$data_operpat = date("Y-m-d H:i:s");
$registro = $conn->query("SELECT * FROM pat WHERE id = $id");
$registro = json_encode($registro->fetch(PDO::FETCH_ASSOC));
$tipo_registro = 'CONVENIO';*/

try
{
	$stmt->execute();
	$_SESSION['msg'] = "Ação excluída com sucesso";

	// LOG
	// --------
	/*$stmt = $conn->prepare("INSERT INTO log(usuario_id, operpat, registro, tipo_registro, data_operpat) 
	values(:usuario_id, :operpat, :registro, :tipo_registro, :data_operpat)");

	$stmt->bindParam(':usuario_id', $usuario_id);
	$stmt->bindParam(':operpat', $operpat);
	$stmt->bindParam(':data_operpat', $data_operpat);
	$stmt->bindParam(':registro', $registro);
	$stmt->bindParam(':tipo_registro', $tipo_registro);

	$stmt->execute();*/
	// ----------------

	header("Location: ../../pages/acao/listar.php?ano=$ano");
}
catch(PDOException $e)
{
	$_SESSION['erro'] = "Erro: " . $e->getMessage();
}

?>