<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

$stmt = $conn->prepare("INSERT INTO usuario(nome, email, senha, perfil_id) 
values(:nome, :email, :senha, :perfil)");

$senha = md5($_POST['senha']);

$stmt->bindParam(':nome', $_POST['nome']);
$stmt->bindParam(':email', $_POST['email']);
$stmt->bindParam(':senha', $senha);
$stmt->bindParam(':perfil', $_POST['perfil']);


try
{
	$stmt->execute();
	$_SESSION['msg'] = "Usuário inserido com sucesso";

	/*// LOG
	// --------
	$usuario_id = $_SESSION['id'];
	$operpat = 'INSERIR';
	$registro = json_encode($_POST);
	$tipo_registro = 'USUÁRIO';
	$data_operpat = date("Y-m-d H:i:s");

	$stmt = $conn->prepare("INSERT INTO log(usuario_id, operpat, registro, tipo_registro, data_operpat) 
	values(:usuario_id, :operpat, :registro, :tipo_registro, :data_operpat)");

	$stmt->bindParam(':usuario_id', $usuario_id);
	$stmt->bindParam(':operpat', $operpat);
	$stmt->bindParam(':data_operpat', $data_operpat);
	$stmt->bindParam(':registro', $registro);
	$stmt->bindParam(':tipo_registro', $tipo_registro);

	$stmt->execute();
	// ----------------
*/

	header("Location: ../../pages/usuarios/listar.php");
}
catch(PDOException $e)
{
	$_SESSION['erro'] = "Erro: " . $e->getMessage();
}

?>