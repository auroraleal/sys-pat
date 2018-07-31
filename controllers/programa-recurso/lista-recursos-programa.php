<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

if (!empty($_GET['find'])) {
    $id = $_GET['find'];

    $stmt = $conn->prepare("SELECT f.nome AS fonte, 
                            f.valor AS recurso_total,
                            pf.valor AS recurso_alocado 
                            FROM programa_has_fonte_recurso pf
                            INNER JOIN programa p ON p.id = pf.programa_id
                            INNER JOIN fonte_recurso f ON f.id = pf.fonte_recurso_id
                            WHERE pf.programa_id = :id");
    
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    
    $tabela = 
        "
            <table>
                <tr>
                    <td><b>Fonte do Recurso</b></td>
                    <td><b>Recurso Total</b></td>
                    <td><b>Recurso Alocado</b></td>
                </tr>
        ";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $tabela .= '<tr>';
            $tabela .= "<td align='center'>" . $row['fonte'] .'</td>';
            $tabela .= "<td align='center'>" . $row['recurso_total'] . '</td>';
            $tabela .= "<td align='center'>" . $row['recurso_alocado'] . '</td>';
        $tabela .= '</tr>';
    }
    $tabela .= "</table>";

    echo $tabela;
} else {
    $tabela = 
        "
            <table>
                <tr>
                    <td><b>Fonte do Recurso</b></td>
                    <td><b>Recurso Total</b></td>
                    <td><b>Recurso Alocado</b></td>
                </tr>
            </table>
        ";
    echo $tabela;
}

?>