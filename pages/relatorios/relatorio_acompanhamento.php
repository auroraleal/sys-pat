<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

/* Carrega a classe DOMPdf */
require_once '../../utils/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$orgao_id = $_POST['orgao'];

$query = "SELECT o.nome AS orgao, p.nome AS programa, 
            a.nome AS acao, a.objetivo AS acao_objetivo, 
            p.nome, p.id as programa_id, a.id as acao_id
        FROM acao a
            INNER JOIN programa p
                ON a.programa_id = p.id
            INNER JOIN programa_has_orgao po
                ON po.programa_id = p.id
            INNER JOIN orgao o
                ON po.orgao_id = o.id
            WHERE o.id = :orgao_id";

if (!empty($_POST['acao'])) {
    $query .= " AND a.id = " . $_POST['acao'];
}
if (!empty($_POST['programa'])) {
    $query .= " AND p.id = " . $_POST['programa'];
}
if (!empty($_POST['ano'])) {
    $query .= " AND a.ano = " . $_POST['ano'];
}

$query_iniciativa = "SELECT i.id as iniciativa_id, 
                        i.descricao as iniciativa_descricao
                     FROM iniciativa i
                        WHERE i.acao_id = :acao_id";

$query_iniciativa_detalhe = "SELECT DISTINCT i.justificativa_nao_executadas, i.metas_extras
                                FROM iniciativa i
                             WHERE i.acao_id = :acao_id";

$query_metas = "SELECT 
                    CASE 
                        WHEN m.quadrimestre = 1 THEN 'Primeiro'
                        WHEN m.quadrimestre = 2 THEN 'Segundo'
                        WHEN m.quadrimestre = 3 THEN 'Terceiro'
                    ELSE '' END AS quadrimestre,
                    m.percentual_planejado, m.percentual_executado
                FROM metas m
                WHERE m.iniciativa_id = :iniciativa_id";
                
if (!empty($_POST['quadrimestre'])) {
    $query_metas .= " AND m.quadrimestre = " .  $_POST['quadrimestre'];
}

$stmt = $conn->prepare($query);
$stmt->bindParam(':orgao_id', $orgao_id);
$stmt->execute();

/* Cria a instância */
$dompdf = new Dompdf();

$html = 
    "<html>
        <head>
            <style>
                .cabecalho { font-size: 13px; font-weight: bold; margin: 3; }
                table {
                    border-collapse: collapse;
                    width: 100%;
                }
                table, th, td {
                    border: 1px solid black;
                    text-align: center;
                }
            </style>
        </head>
        <body>";

$i = 0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $html .= 
    "<div align='center'>
                <img src='../../imagens/brasao.png' height=100px width=100px></img>
            </div>
            <div style='margin-top: 15px' align='center'>
                <p class='cabecalho'>PREFEITURA MUNICIPAL DE MACAPÁ</p>
                <p class='cabecalho'>SECRETARIA MUNICIPAL DE PLANEJAMENTO E COORDENAÇÃO GERAL</p>
                <p class='cabecalho'>COORDENAÇÃO DE PLANEJAMENTO, ORÇAMENTO E MODERNIZAÇÃO ADMINISTRATIVA</p>
                <p class='cabecalho'>DEPARTAMENTO DE PLANEJAMENTO INTEGRADO</p>
            </div>
            <div align='center'>
                <p><b> RELATÓRIO DE ACOMPANHAMENTO DE EXECUÇÃO DO PPA - PMM</b></p>
                &nbsp;<span><b>Exercício: " . $_POST['ano'] . "</b></span>
            </div>
            <div style='margin-top: 15px;'>
                <p>1 - <b>Órgão: </b>" . $row['orgao'] . "</p>
                <p>2 - <b>Programa: </b>" . $row['programa'] . "</p>
                <p>3 - <b>Ação: </b>" . $row['acao'] . "</p>
                <div style='margin-top: -15px; margin-left: 20px'>
                    <p>3.1 - <b>Objetivo: </b>" . $row['acao_objetivo'] . "</p>
                    <p>3.2 - <b>Recurso</b></p>
                    <div style='margin-top: 20px; margin-bottom: 20px'>";

                    $stmt_dotacao_final = $conn->prepare("SELECT SUM(valor_atual) as dotacao_final 
                                                        FROM dotacao_orcamentaria 
                                                    WHERE acao_id = :acao_id;");
                    if (!empty($_POST['acao'])) {
                        $stmt_dotacao_final->bindParam(':acao_id', $_POST['acao']);
                    } else {
                        $stmt_dotacao_final->bindParam(':acao_id', $row['acao_id']);
                    }

                    $stmt_dotacao_final->execute();
                    $row_dotacao_final = $stmt_dotacao_final->fetch(PDO::FETCH_ASSOC);

                    $stmt_recurso = $conn->prepare("SELECT f.nome AS fonte, 
                    f.valor AS recurso_total
                    FROM acao_has_fonte_recurso af
                    INNER JOIN acao a ON a.id = af.acao_id
                    INNER JOIN fonte_recurso f ON f.id = af.fonte_recurso_id
                    WHERE af.acao_id = :acao_id");
    
                    $stmt_recurso->bindParam(':acao_id', $row['acao_id']);
                    $stmt_recurso->execute();
                    
                    $tabela = 
                        "
                            <table>
                                <tr>
                                    <td><b>Fonte do Recurso</b></td>
                                    <td><b>Dotação Inicial (R$)</b></td>
                                </tr>
                        ";
                    while ($row_recurso = $stmt_recurso->fetch(PDO::FETCH_ASSOC)) {
                        $tabela .= '<tr>';
                            $tabela .= "<td align='center'>" . $row_recurso['fonte'] .'</td>';
                            $tabela .= "<td align='center'>" . number_format($row_recurso['recurso_total'], 2, ',', '.') . '</td>';                            
                        $tabela .= '</tr>';
                    }
                    $tabela .= "</table>";

                $html .= $tabela . "<br><b>Dotação Final: </b> R$ " . number_format($row_dotacao_final['dotacao_final'], 2, ',', '.') . " </div></div>";

                $stmt_iniciativa = $conn->prepare($query_iniciativa);
                if (!empty($_POST['acao'])) {
                    $stmt_iniciativa->bindParam(':acao_id', $_POST['acao']);
                } else {
                    $stmt_iniciativa->bindParam(':acao_id', $row['acao_id']);
                }

                $stmt_iniciativa->execute();

                $html .= "<div style='margin-top: -20px'>
                        <p>4 - <b>Iniciativas</b> - Quantidade: " . $stmt_iniciativa->rowCount() . "</p>";

                while ($row_iniciativa = $stmt_iniciativa->fetch(PDO::FETCH_ASSOC)) {
                    $html .= "
                        <div style='margin-top: -5px;'>
                            <p><b>Descrição: </b>" . $row_iniciativa['iniciativa_descricao'] . "</p>
                        </div>
                        <table>
                            <tr>
                                <td><b>Quadrimestre</b></td>
                                <td><b>Meta Planejada (%)</b></td>
                                <td><b>Meta Executada (%)</b></td>
                            </tr>";

                    $stmt_metas = $conn->prepare($query_metas);
                    $stmt_metas->bindParam(':iniciativa_id', $row_iniciativa['iniciativa_id']);
                    $stmt_metas->execute();

                    while ($row_metas = $stmt_metas->fetch(PDO::FETCH_ASSOC)) {
                        $html .= "
                                <tr>
                                    <td>" . $row_metas['quadrimestre'] . "</td>
                                    <td>" . $row_metas['percentual_planejado'] . "</td>
                                    <td>" . $row_metas['percentual_executado'] . "</td>
                                </tr>";
                    }
                $html .= "</table>
                </div>";
            }

            $stmt_iniciativa_detalhe = $conn->prepare($query_iniciativa_detalhe);
            if (!empty($_POST['acao'])) {
                $stmt_iniciativa_detalhe->bindParam(':acao_id', $_POST['acao']);
            } else {
                $stmt_iniciativa_detalhe->bindParam(':acao_id', $row['acao_id']);
            }
            $stmt_iniciativa_detalhe->execute();

            while ($row_iniciativa_detalhe = $stmt_iniciativa_detalhe->fetch(PDO::FETCH_ASSOC)) {
                $html .= "
                <div>
                    <p>5 - <b>Justificativa das Metas não Executadas: </b>
                    <div style='margin-top: -15px; margin-left: 20px'>
                        <p> ". $row_iniciativa_detalhe['justificativa_nao_executadas'] . "</p>
                    </div>
                </div>
                <div>
                    <p>6 - <b>Meta Extra Planejada: </b>
                    <div style='margin-top: -15px; margin-left: 20px'>
                            <p> ". $row_iniciativa_detalhe['metas_extras'] . "</p>
                    </div>
                </div>";
            }
            
            // ACRESCENTA UMA QUEBRA DE PÁGINA APENAS
            // SE ATÉ A PENULTIMA PÁGINA
            if ($i != ($stmt->rowCount() - 1))
                $html .= "<div style='page-break-after: always'></div>";
            
            $i++;
}

$html .= "  </body>
        </html>";

/* Carrega seu HTML */
$dompdf->load_html($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

/* Renderiza */
$dompdf->render();

$canvas = $dompdf->get_canvas();
$canvas->page_text(0, 0, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10, array(0, 0, 0));

/* Exibe */
$dompdf->stream(
    "sys-pat_relatorio.pdf", /* Nome do arquivo de saída */
    array(
        "Attachment" => false /* Para download, altere para true */
    )
);
?>