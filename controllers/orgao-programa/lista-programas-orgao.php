<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

if (!empty($_GET['find'])) {
    $orgao_id = $_GET['find'];

    $stmt = $conn->prepare("SELECT p.id, p.nome FROM programa_has_orgao po
                                INNER JOIN programa p
                                ON po.programa_id = p.id
                            WHERE po.orgao_id = :orgao_id;");
    $stmt->bindParam(':orgao_id', $orgao_id);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<option value="'.$row['id'].'">'.$row['nome'].'</option>';
    }
} else {
    echo '<option value=""> Selecione </option>';
}

?>