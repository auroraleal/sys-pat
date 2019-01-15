<?php 
session_start();
include '../../utils/bd.php'; 
include '../../utils/valida_login.php';

$acao_id = $_GET['id'];

// INFORMAÇÕES DA AÇÃO
$stmt = $conn->prepare("SELECT a.quantidade_iniciativas, a.nome as acao, p.nome as programa FROM acao a 
                          INNER JOIN programa p ON a.programa_id = p.id
                        WHERE a.id = :acao_id;");
$stmt->bindParam(':acao_id', $acao_id);

$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Acompanha-Macapá</title>
  <link href="/imagens/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/skin-green-light.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    th, td {
      padding: 5px;
    }
  </style>
</head>
<body class="hold-transition skin-green-light sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <?php include ('../../layout/header.php') ?>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <?php include ('../../layout/menu-lateral.php') ?>


  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
    	<div class="row">
	        <!-- left column -->

    	<div class="col-md-10 form-cadastro">
          <!-- general form elements -->
            
   			<div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Iniciativas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" action="../../controllers/iniciativa/new.php" method="post">
                <input type="hidden" name="acao_id" value="<?=$acao_id?>"/>
                <input type="hidden" name="quantidade_iniciativas" value="<?=$row['quantidade_iniciativas']?>"/>
                <h4>Acão: <b><?php echo $row['acao']?></b></h4>
                <h4>Programa: <b><?php echo $row['programa']?></b></h4>
 
                <!-- DOTAÇÃO -->
                <?php
                  // VERIFICA SE JÁ EXISTE DOTAÇÃO CADASTRADA PARA A AÇÃO
                  $stmt_dotacao = $conn->prepare("SELECT * FROM dotacao_orcamentaria 
                                                  WHERE acao_id = :acao_id
                                                  ORDER BY quadrimestre ASC;");
                  $stmt_dotacao->bindParam(':acao_id', $acao_id);
                  $stmt_dotacao->execute();
                  $row_dotacao = $stmt_dotacao->fetchAll(PDO::FETCH_ASSOC);

                  $html_dotacao = 
                  "
                  <div style='border: 1px solid black; padding: 15px;'>
                      <div class='row'>
                          <h5 align='center' style='margin: 0 auto'><b>Dotação Orçamentária</b><h5>
                          <hr style='border: 0.5px solid black;'>
                  ";
                  $dotacao_final = 0;
                  $quad = 1;
                  for ($i = 0; $i <= 2; $i++) {
                      if ($stmt_dotacao->rowCount() > 0)
                        $dotacao = $row_dotacao[$i];

                          $html_dotacao .=
                          "
                          <div class='col-md-4'>
                              <table>
                              <tr>
                                  <td></td>
                                  <td align='center'><b>Quadrimestre " . $quad . "</b></td>
                              </tr>
                              <tr>
                                  <td>Inicial</td> ";
                              
                              if (isset($dotacao)) {
                                if ($dotacao['quadrimestre'] == $quad) {
                                    $valor_inicial = $dotacao['valor_inicial'];
                                    $html_dotacao .=
                                    "
                                    <td><input type='text' name='quad_".$quad."_inicial' class='form-control money' placeholder='' value='$valor_inicial'></td>
                                    ";
                                }
                              } else {
                                $html_dotacao .=
                                "
                                <td><input type='text' name='quad_".$quad."_inicial' class='form-control money' placeholder='' value='0'></td>
                                ";
                              }
                              $html_dotacao .= 
                              "
                              </tr>
                              <tr>
                                <td>Atual</td>";
                                if (isset($dotacao)) {
                                  if ($dotacao['quadrimestre'] == $quad) {
                                      $valor_atual = $dotacao['valor_atual'];
                                      $dotacao_final += $valor_atual;
                                      $html_dotacao .=
                                      "
                                      <td><input type='text' name='quad_".$quad."_atual' class='form-control money' placeholder='' value='$valor_atual'></td>
                                      ";
                                  }
                                } else {
                                  $html_dotacao .=
                                  "
                                  <td><input type='text' name='quad_".$quad."_atual' class='form-control money' placeholder='' value='0'></td>
                                  ";
                                }
                              $html_dotacao .=
                              "
                              </tr>
                              </table>
                          </div>
                          ";
                          $quad++;
                  }

                  $html_dotacao .=
                  "
                      </div> <!-- fim row -->
                      <h5 align='left' style='margin-top: 20px'><b>Dotação Final: R$ " . 
                        number_format($dotacao_final, 2, ',', '.') . 
                      "</b><h5></div>";

                  echo $html_dotacao;
                ?>
                <br>
                <?php
                  // VERIFICA SE JÁ EXISTEM INICIATIVAS CADASTRADAS PARA A AÇÃO
                  $stmt_iniciativa = $conn->prepare("SELECT * FROM iniciativa WHERE acao_id = :acao_id;");
                  $stmt_iniciativa->bindParam(':acao_id', $acao_id);

                  $stmt_iniciativa->execute();
                  $rs_iniciativas = $stmt_iniciativa->fetchAll(PDO::FETCH_ASSOC);
                  $tem_iniciativas = !empty($rs_iniciativas);

                  $quantidade_iniciativas = $row['quantidade_iniciativas'];
                  
                  $html_iniciativas = "";
                  for ($i = 1; $i <= $quantidade_iniciativas; $i++) {
                    if (count($rs_iniciativas) > 0) {
                      $posicao = $i - 1;

                      $iniciativa_id = $rs_iniciativas[$posicao]['id'];
                      $descricao     = $rs_iniciativas[$posicao]['descricao'];    
                      $justificativa = $rs_iniciativas[$posicao]['justificativa_nao_executadas'];
                      $metas         = $rs_iniciativas[$posicao]['metas_extras'];
                    }
                    
                    $html_iniciativas .= 
                      "
                      <a class='btn btn-success' role='button' data-toggle='collapse' href='#collapse$i' aria-expanded='false' aria-controls='collapseExample'>
                        Iniciativa " . $i .
                      "</a>
                      <br> <br>
                      <div class='collapse' id='collapse$i'>
                        <div class='col-md-12'>
                          <div class='form-group' style='margin-top: 10px'>
                            <label>Descrição</label>";
                            if ($tem_iniciativas) {
                              $html_iniciativas .= "<textarea class='form-control' rows='5' name='descricao_iniciativa$i'>$descricao</textarea>";
                            } else {
                              $html_iniciativas .= "<textarea class='form-control' rows='5' name='descricao_iniciativa$i'></textarea>";
                            }
                            $html_iniciativas .= 
                            "
                          </div>
                        </div>
                        <div style='border: 1px solid black; padding: 15px;'>
                          <hr style='border: 0.5px solid black;'>
                          <h5 align='center' style='margin: 0 auto'><b>Metas</b><h5>
                          <hr style='border: 0.5px solid black;'>
                          <div class='row'>";
                              for ($y = 1; $y <= 3; $y++) {
                                // VERIFICA AS METAS DE CADA INICIATIVA CADASTRADAS PARA A AÇÃO
                                $stmt_metas = $conn->prepare("SELECT * FROM metas WHERE iniciativa_id = :iniciativa_id;");
                                $stmt_metas->bindParam(':iniciativa_id', $iniciativa_id);

                                $stmt_metas->execute();
                                $rs_metas = $stmt_metas->fetchAll(PDO::FETCH_ASSOC);
                                $tem_metas = !empty($rs_metas);

                                if ($tem_metas) {
                                  $index_meta = $y - 1;
                                  $meta_id = $rs_metas[$index_meta]['id'];
                                  $meta_planejada = $rs_metas[$index_meta]['percentual_planejado'];
                                  $meta_executada = $rs_metas[$index_meta]['percentual_executado'];
                                  $html_iniciativas .= 
                                  "
                                    <input type='hidden' name='meta_id[]' 
                                    value='$meta_id'>
                                  ";
                                }

                                $index_meta_planejada = "quad_perc_plan$i$y";
                                $index_meta_executada = "quad_perc_exec$i$y";

                                $html_iniciativas .= 
                                "<div class='col-md-4'>
                                  <table>
                                    <tr>
                                      <td></td>
                                      <td align='center'><b>Quadrimestre $y</b></td>
                                    </tr>
                                    <tr>
                                      <td>Percentual Planejado</td>";

                                      if ($tem_metas) {
                                        $html_iniciativas .= 
                                        "
                                        <td>
                                          <input type='text' name='$index_meta_planejada' 
                                          class='form-control' placeholder='' value='$meta_planejada'>
                                        </td>";
                                      } else {
                                        $html_iniciativas .= 
                                        "
                                        <td>
                                          <input type='text' name='$index_meta_planejada' 
                                          class='form-control' placeholder='' value='0'>
                                        </td>";
                                      }
                                    $html_iniciativas .= 
                                    "</tr>";
                                      $html_iniciativas .= 
                                      "
                                      <tr>
                                        <td>Percentual Executado</td>";

                                        if ($tem_metas) {
                                          $html_iniciativas .= 
                                          "
                                          <td>
                                            <input type='text' name='$index_meta_executada' 
                                            class='form-control' placeholder='' value='$meta_executada'>
                                          </td>";
                                        } else {
                                          $html_iniciativas .= 
                                          "<td>
                                            <input type='text' name='$index_meta_executada' 
                                            class='form-control' placeholder='' value='0'>
                                          </td>";
                                        }
                                    $html_iniciativas .= 
                                    "
                                    </tr>
                                  </table>
                                </div>";
                              }
                            $html_iniciativas .=   
                            "</div>
                          </div>
                        </div>
                      <br>  
                      ";
                  }
                  echo $html_iniciativas;
                ?>
                <div class="col-md-12">
                  <div class="form-group" style="margin-top: 10px">
                    <label>Justificativa das Metas não Executadas</label>
                    <textarea class="form-control" rows="5" name="justificativa_metas_n_exec"><?php if (isset($justificativa)) echo $justificativa ?></textarea>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group" style="margin-top: 10px">
                    <label>Meta Extra Programada</label>
                    <textarea class="form-control" rows="5" name="metas_extras"><?php if (isset($metas)) echo $metas ?></textarea>
                  </div>
                </div>
              <div class="box-footer" style="margin: 0 auto; width: 150px">
                <button type="submit" class="btn btn-success" style="margin-left: 15px">Salvar</button>
              </div>
            </div>
<!-- text input -->
</form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include ('../../layout/footer.html');?>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../../assets/js/jquery.mask.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

<script>
  $.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^]*)').exec(window.location.href);
    if (results==null){
       return null;
    }
    else{
       return results[1] || 0;
    }
  }

  $(document).ready(function () {
    
    /*$.get('../../controllers/programa-recurso/lista-recursos-programa.php?find=' + valor, function(data) {
        $('#fonte_recurso').empty();
        $('#fonte_recurso').append(data);
    });*/

    $('.money').mask('000.000.000.000.000,00', {reverse: true});
  });
</script>
</body>
</html>
