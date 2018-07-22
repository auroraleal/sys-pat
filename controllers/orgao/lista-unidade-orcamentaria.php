<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

if (!empty($_GET['find'])) {
    $id = $_GET['find'];

    $stmt = $conn->prepare("SELECT unidade_orcamentaria FROM orgao WHERE id = :id;");
    $stmt->bindParam(':id', $id);

    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo $row['unidade_orcamentaria'];
} else {
    echo '';
}

?>