<?php
/* Carrega a classe DOMPdf */
require_once '../utils/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

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
    <body>
        <div align='center'>
            <img src='../imagens/brasao.png' height=100px width=100px></img>
        </div>
        <div style='margin-top: 15px' align='center'>
            <p class='cabecalho'>PREFEITURA MUNICIPAL DE MACAPÁ</p>
            <p class='cabecalho'>SECRETARIA MUNICIPAL DE PLANEJAMENTO E COORDENAÇÃO GERAL</p>
            <p class='cabecalho'>COORDENAÇÃO DE PLANEJAMENTO, ORÇAMENTO E MODERNIZAÇÃO ADMINISTRATIVA</p>
            <p class='cabecalho'>DEPARTAMENTO DE PLANEJAMENTO INTEGRADO</p>
        </div>
        <div align='center'>
            <p> RELATÓRIO DE ACOMPANHAMENTO DE EXECUÇÃO DO PPA ___-___ - PMM</p>
            <span>Exercício _______</span> &nbsp; &nbsp; &nbsp; <span>Quadrimestre _______</span>
        </div>
        <div style='margin-top: 30px; margin-left: 40px'>
            <p>1 - <b>Órgão:</b></p>
            <p>2 - <b>Programa:</b></p>
            <div style='margin-top: -15px; margin-left: 20px'>
                <p>2.1 - <b>Objetivo:</b></p>
            </div>
            <p>3 - Ação:</p>
            <div style='margin-top: -15px; margin-left: 20px'>
                <p>3.1 - <b>Objetivo:</b></p>
                <span>3.2 - <b>Recurso Disponível:</b></span> &nbsp; &nbsp; &nbsp; <span>Valor Inicial: R$ _______</span> 
                &nbsp; &nbsp; &nbsp; <span>Valor Atual: R$ _______</span>
            </div>
            <div style='margin-left: 20px'>
                <p>3.2.1 - <b>Valor por Fontes de Recursos:</b></p> 
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span><b>____ TESOURO:</b></span>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                <span>Valor: R$ _______</span>
            </div>
            <div style='margin-top: 40px; margin-left: 20px'>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <span><b>____ FEDERAL:</b></span>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                <span>Valor: R$ _______</span>
            </div>
            <div>
                <p>4 - <b>Iniciativas/Metas Planejadas:</b></p>
                <table>
                    <tr>
                        <td><b>Iniciativa</b></td>
                        <td><b>Meta Planejada</b></td>
                        <td><b>Meta Executada</b></td>
                    </tr>
                </table>
            </div>
            <p>5 - <b>Justificativa das Metas não Executadas:</b></p>
            <p>6 - <b>Meta Extra Planejada:</b></p>
        </div>
    </body>
</html>";

/* Carrega seu HTML */
$dompdf->load_html($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');

/* Renderiza */
$dompdf->render();

/* Exibe */
$dompdf->stream(
    "sys-pat_relatorio.pdf", /* Nome do arquivo de saída */
    array(
        "Attachment" => false /* Para download, altere para true */
    )
);
?>