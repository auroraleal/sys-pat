<?php
/* Carrega a classe DOMPdf */
require_once '../utils/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

/* Cria a instância */
$dompdf = new Dompdf();

$teste = 'testando variavel';
$html = "
<div align='center'>
<img src='../imagens/logo_pmm.png'></img>
</div>
<br>

<p>Adicione seu HTML aqui. $teste</p>";

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