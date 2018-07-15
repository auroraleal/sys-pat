<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';
$stmt = $conn->prepare("UPDATE usuario SET senha = :senha
WHERE id = :id");
$senha = md5($_POST['senha']);
$stmt->bindParam(':id', $_SESSION['id']);
$stmt->bindParam(':senha', $senha);
try
{
	$stmt->execute();

	// LOG
	$usuario_id = $_SESSION['id'];
	$operpat = 'ALTERAR SENHA';
	$data_operpat = date("Y-m-d H:i:s");
	$registro = $conn->query("SELECT * FROM usuario WHERE id = $id");
	$registro = json_encode($registro->fetch(PDO::FETCH_ASSOC));
	$tipo_registro = 'SENHA';
	
	// --------
	$stmt = $conn->prepare("INSERT INTO log(usuario_id, operpat, registro, tipo_registro, data_operpat) 
	values(:usuario_id, :operpat, :registro, :tipo_registro, :data_operpat)");

	$stmt->bindParam(':usuario_id', $usuario_id);
	$stmt->bindParam(':operpat', $operpat);
	$stmt->bindParam(':data_operpat', $data_operpat);
	$stmt->bindParam(':registro', $registro);
	$stmt->bindParam(':tipo_registro', $tipo_registro);

	$stmt->execute();

	$_SESSION['msg'] = "Senha alterada com sucesso";
	header("Location: ../../pages/usuarios/alterar-senha.php");
}
catch(PDOException $e)
{
	$_SESSION['erro'] = "Erro: " . $e->getMessage();
}
?>