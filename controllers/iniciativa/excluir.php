<?php
session_start();
include '../../utils/bd.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM acao WHERE id = $id");

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
	$_SESSION['msg'] = "pat excluído com sucesso";

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

	header("Location: ../../pages/acao/listar.php");
}
catch(PDOException $e)
{
	$_SESSION['erro'] = "Erro: " . $e->getMessage();
}

?>