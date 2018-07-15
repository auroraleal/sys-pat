<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

$stmt = $conn->prepare("UPDATE usuario SET nome = :nome, email = :email, senha = :senha, 
perfil_id = :perfil_id  WHERE id = :id ");

$id = $_POST['id'];

$stmt->bindParam(':nome', $_POST['nome']);
$stmt->bindParam(':email', $_POST['email']);
$stmt->bindParam(':senha', $_POST['senha']);
$stmt->bindParam(':perfil_id', $_POST['perfil']);
$stmt->bindParam(':id', $id);

try
{
	$stmt->execute();
	$_SESSION['msg'] = "Usuario editado com sucesso";
  // --------
	// LOG
	$usuario_id = $_SESSION['id'];
	$operpat = 'EDITAR';
	$data_operpat = date("Y-m-d H:i:s");
	$registro = $conn->query("SELECT * FROM usuario WHERE id = $id");
	$registro = json_encode($registro->fetch(PDO::FETCH_ASSOC));
	$tipo_registro = 'USUÁRIO';
	
	// --------
	$stmt = $conn->prepare("INSERT INTO log(usuario_id, operpat, registro, tipo_registro, data_operpat) 
	values(:usuario_id, :operpat, :registro, :tipo_registro, :data_operpat)");

	$stmt->bindParam(':usuario_id', $usuario_id);
	$stmt->bindParam(':operpat', $operpat);
	$stmt->bindParam(':data_operpat', $data_operpat);
	$stmt->bindParam(':registro', $registro);
	$stmt->bindParam(':tipo_registro', $tipo_registro);

	$stmt->execute();
	// ----------------

	header("Location: ../../pages/usuarios/listar.php?id=$id");
}
catch(PDOException $e)
{
	$_SESSION['erro'] = "Erro: " . $e->getMessage();
}

?>