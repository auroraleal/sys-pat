<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

/* Carrega a classe DOMPdf */
require_once '../../utils/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

//die(var_dump($_POST));

$orgao_id = $_POST['orgao'];

$query = "SELECT o.nome AS orgao, p.nome AS programa, 
            a.nome AS acao, a.objetivo AS acao_objetivo, 
            p.nome, f.nome AS fonte, f.valor AS recurso_total, 
            pf.valor AS recurso_alocado, i.id as iniciativa_id, 
            i.descricao as iniciativa_descricao,
            i.justificativa_nao_executadas, i.metas_extras
          FROM iniciativa i
            INNER JOIN acao a
                ON i.acao_id = a.id
            INNER JOIN programa p
                ON a.programa_id = p.id
            INNER JOIN programa_has_orgao po
                ON po.programa_id = p.id
            INNER JOIN orgao o
                ON po.orgao_id = o.id
            INNER JOIN programa_has_fonte_recurso pf
                ON p.id = pf.programa_id
            INNER JOIN fonte_recurso f 
                ON f.id = pf.fonte_recurso_id";

$query_metas = "SELECT i.descricao, m.quadrimestre, 
            m.percentual_planejado, m.percentual_executado
          FROM metas m
            INNER JOIN iniciativa i
            ON i.id = m.iniciativa_id
          WHERE i.id = :iniciativa_id";

$stmt = $conn->prepare($query);
//$stmt->bindParam(':orgao_id', $orgao_id);
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
                <p> RELATÓRIO DE ACOMPANHAMENTO DE EXECUÇÃO DO PPA ___-___ - PMM</p>
                <span>Exercício: " . $_POST['ano'] . "</span> &nbsp; &nbsp; &nbsp; <span>Quadrimestre: " . $_POST['quadrimestre'] . "</span>
            </div>
            <div style='margin-top: 15px; margin-left: 15px'>
                <p>1 - <b>Órgão: </b>" . $row['orgao'] . "</p>
                <p>2 - <b>Programa: </b>" . $row['programa'] . "</p>
                <p>3 - <b>Ação: </b>" . $row['acao'] . "</p>
                <div style='margin-top: -15px; margin-left: 20px'>
                    <p>3.1 - <b>Objetivo: </b>" . $row['acao_objetivo'] . "</p>
                    <p>3.2 - <b>Recurso</b></p>
                    <div style='margin-top: -15px; margin-left: 20px'> 
                        <p><b>Total:</b> R$ " . $row['recurso_total'] . " 
                        &nbsp; &nbsp; &nbsp;<span><b>Alocado:</b> R$" . $row['recurso_alocado'] . "</span>
                    </div>    
                </div>
                <div style='margin-top: -20px'>
                    <p>4 - <b>Iniciativas/Metas Planejadas</b></p>
                    <div style='margin-top: -15px; margin-left: 20px'>
                        <p>4.1 - <b>Descrição: </b>" . $row['iniciativa_descricao'] . "</p>
                    </div>
                    <table>
                        <tr>
                            <td><b>Quadrimestre</b></td>
                            <td><b>Meta Planejada (%)</b></td>
                            <td><b>Meta Executada (%)</b></td>
                        </tr>";

                $stmt_metas = $conn->prepare($query_metas);
                $stmt_metas->bindParam(':iniciativa_id', $row['iniciativa_id']);
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
                    </div>
                <div>
                    <p>5 - <b>Justificativa das Metas não Executadas: </b>
                    <div style='margin-top: -15px; margin-left: 20px'>
                        <p> ". $row['justificativa_nao_executadas'] . "</p>
                    </div>
                </div>
                <div>
                    <p>6 - <b>Meta Extra Planejada: </b>
                    <div style='margin-top: -15px; margin-left: 20px'>
                            <p> ". $row['metas_extras'] . "</p>
                    </div>
                </div>";

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