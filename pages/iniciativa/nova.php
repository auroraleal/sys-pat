<?php 
session_start();
include '../../utils/bd.php'; 
include '../../utils/valida_login.php';

$acao_id = $_GET['id'];

$stmt = $conn->prepare("SELECT a.nome as acao, p.nome as programa FROM acao a 
                          INNER JOIN programa p ON a.programa_id = p.id
                        WHERE a.id = $acao_id;");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sys-PAT Macapá</title>
  <link href="/sys-pat/imagens/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
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

    	<div style="margin-left: 100px" class="col-md-10">
          <!-- general form elements -->
            
   			<div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Iniciativas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" action="../../controllers/acao/new-acao.php" method="post">
                <h4>Acão: <b><?php echo $row['acao']?></b></h4>
                <h4>Programa: <b><?php echo $row['programa']?></b></h4>
                <div style="border: 1px solid black; padding: 15px;">
                  <div class="row">
                    <h5 align="center" style="margin: 0 auto"><b>Dotação Orçamentária</b><h5>
                    <hr style="border: 0.5px solid black;">
                    <div class="col-md-4">
                      <table>
                        <tr>
                          <td></td>
                          <td><b>Primeiro Quadrimestre</b></td>
                        </tr>
                        <tr>
                          <td>Inicial</td>
                          <td><input type="text" name="" class="form-control" placeholder=""></td>
                        </tr>
                        <tr>
                          <td>Atual</td>
                          <td><input type="text" name="" class="form-control" placeholder=""></td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-md-4">
                      <table>
                        <tr>
                          <td></td>
                          <td><b>Segundo Quadrimestre</b></td>
                        </tr>
                        <tr>
                          <td>Inicial</td>
                          <td><input type="text" name="" class="form-control" placeholder=""></td>
                        </tr>
                        <tr>
                          <td>Atual</td>
                          <td><input type="text" name="" class="form-control" placeholder=""></td>
                        </tr>
                      </table>
                    </div>
                    <div class="col-md-4">
                      <table>
                        <tr>
                          <td></td>
                          <td><b>Terceiro Quadrimestre</b></td>
                        </tr>
                        <tr>
                          <td>Inicial</td>
                          <td><input type="text" name="" class="form-control" placeholder=""></td>
                        </tr>
                        <tr>
                          <td>Atual</td>
                          <td><input type="text" name="" class="form-control" placeholder=""></td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
                <br>
                <a class="btn btn-success" role="button" data-toggle="collapse" href="#collapse1" aria-expanded="false" aria-controls="collapseExample">
                  Iniciativa 1
                </a>
                <br> <br>
                <div class="collapse" id="collapse1">
                  <div class="col-md-12">
                    <div class="form-group" style="margin-top: 10px">
                      <label>Descrição</label>
                      <textarea class="form-control" rows="5" name=""></textarea>
                    </div>
                  </div>
                  <div style="border: 1px solid black; padding: 15px;">
                    <div class="row">
                      <div class="col-md-4">
                        <table>
                          <tr>
                            <td></td>
                            <td><b>Primeiro Quadrimestre</b></td>
                          </tr>
                          <tr>
                            <td>Meta Planejada</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                          <tr>
                            <td>Meta Executada</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                          <tr>
                            <td>Percentual Atingido</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                        </table>
                      </div>
                      <div class="col-md-4">
                      <table>
                          <tr>
                            <td></td>
                            <td><b>Segundo Quadrimestre</b></td>
                          </tr>
                          <tr>
                            <td>Meta Planejada</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                          <tr>
                            <td>Meta Executada</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                          <tr>
                            <td>Percentual Atingido</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                        </table>
                      </div>
                      <div class="col-md-4">
                        <table>
                            <tr>
                              <td></td>
                              <td><b>Terceiro Quadrimestre</b></td>
                            </tr>
                            <tr>
                              <td>Meta Planejada</td>
                              <td><input type="text" name="" class="form-control" placeholder=""></td>
                            </tr>
                            <tr>
                              <td>Meta Executada</td>
                              <td><input type="text" name="" class="form-control" placeholder=""></td>
                            </tr>
                            <tr>
                              <td>Percentual Atingido</td>
                              <td><input type="text" name="" class="form-control" placeholder=""></td>
                            </tr>
                          </table>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <a class="btn btn-success" role="button" data-toggle="collapse" href="#collapse2" aria-expanded="false" aria-controls="collapseExample">
                  Iniciativa 2
                </a>
                <br> <br>
                <div class="collapse" id="collapse2">
                  <div class="col-md-12">
                    <div class="form-group" style="margin-top: 10px">
                      <label>Descrição</label>
                      <textarea class="form-control" rows="5" name=""></textarea>
                    </div>
                  </div>
                  <div style="border: 1px solid black; padding: 15px;">
                    <div class="row">
                      <div class="col-md-4">
                        <table>
                          <tr>
                            <td></td>
                            <td><b>Primeiro Quadrimestre</b></td>
                          </tr>
                          <tr>
                            <td>Meta Planejada</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                          <tr>
                            <td>Meta Executada</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                          <tr>
                            <td>Percentual Atingido</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                        </table>
                      </div>
                      <div class="col-md-4">
                      <table>
                          <tr>
                            <td></td>
                            <td><b>Segundo Quadrimestre</b></td>
                          </tr>
                          <tr>
                            <td>Meta Planejada</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                          <tr>
                            <td>Meta Executada</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                          <tr>
                            <td>Percentual Atingido</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                        </table>
                      </div>
                      <div class="col-md-4">
                        <table>
                            <tr>
                              <td></td>
                              <td><b>Terceiro Quadrimestre</b></td>
                            </tr>
                            <tr>
                              <td>Meta Planejada</td>
                              <td><input type="text" name="" class="form-control" placeholder=""></td>
                            </tr>
                            <tr>
                              <td>Meta Executada</td>
                              <td><input type="text" name="" class="form-control" placeholder=""></td>
                            </tr>
                            <tr>
                              <td>Percentual Atingido</td>
                              <td><input type="text" name="" class="form-control" placeholder=""></td>
                            </tr>
                          </table>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <a class="btn btn-success" role="button" data-toggle="collapse" href="#collapse3" aria-expanded="false" aria-controls="collapseExample">
                  Iniciativa 3
                </a>
                <br> <br>
                <div class="collapse" id="collapse3">
                  <div class="col-md-12">
                    <div class="form-group" style="margin-top: 10px">
                      <label>Descrição</label>
                      <textarea class="form-control" rows="5" name=""></textarea>
                    </div>
                  </div>
                  <div style="border: 1px solid black; padding: 15px;">
                    <div class="row">
                      <div class="col-md-4">
                        <table>
                          <tr>
                            <td></td>
                            <td><b>Primeiro Quadrimestre</b></td>
                          </tr>
                          <tr>
                            <td>Meta Planejada</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                          <tr>
                            <td>Meta Executada</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                          <tr>
                            <td>Percentual Atingido</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                        </table>
                      </div>
                      <div class="col-md-4">
                      <table>
                          <tr>
                            <td></td>
                            <td><b>Segundo Quadrimestre</b></td>
                          </tr>
                          <tr>
                            <td>Meta Planejada</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                          <tr>
                            <td>Meta Executada</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                          <tr>
                            <td>Percentual Atingido</td>
                            <td><input type="text" name="" class="form-control" placeholder=""></td>
                          </tr>
                        </table>
                      </div>
                      <div class="col-md-4">
                        <table>
                            <tr>
                              <td></td>
                              <td><b>Terceiro Quadrimestre</b></td>
                            </tr>
                            <tr>
                              <td>Meta Planejada</td>
                              <td><input type="text" name="" class="form-control" placeholder=""></td>
                            </tr>
                            <tr>
                              <td>Meta Executada</td>
                              <td><input type="text" name="" class="form-control" placeholder=""></td>
                            </tr>
                            <tr>
                              <td>Percentual Atingido</td>
                              <td><input type="text" name="" class="form-control" placeholder=""></td>
                            </tr>
                          </table>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              <div class="box-footer" style="margin: 0 auto; width: 150px">
                <button type="submit" class="btn btn-default" style="margin-left: 15px">Cadastrar</button>
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
  $(document).ready(function () {
    $('.date').mask('00/00/0000');
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
  });
</script>
</body>
</html>
