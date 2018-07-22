<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

if (!empty($_GET['find'])) {
    $funcao_id = $_GET['find'];

    $stmt = $conn->prepare("SELECT id, nome FROM subfuncao WHERE funcao_id = :funcao_id;");
    $stmt->bindParam(':funcao_id', $funcao_id);

    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="'.$row['id'].'">'.$row['nome'].'</option>';
    }
} else {
    echo '<option value=""> Selecione </option>';
}

?>