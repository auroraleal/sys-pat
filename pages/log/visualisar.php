<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

$log_id = $_GET['id'];

$stmt = $conn->prepare("SELECT l.id, l.operpat, l.data_operpat, 
                               l.registro, l.tipo_registro, u.nome as usuario
                        FROM log l 
                          INNER JOIN usuario u 
                          ON l.usuario_id = u.id
                        WHERE l.id = :id;");

$stmt->bindParam(':id', $log_id);
$stmt->execute();

$results = $stmt->fetch(PDO::FETCH_ASSOC);
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
        <div class="col-xs-12">
          <?php if (isset($_SESSION['msg'])) { ?>
    <div class="alert alert-info">
      <strong>Info:</strong> 
      <?php echo $_SESSION['msg']; unset($_SESSION['msg']);?>
    </div>
  <?php } ?>

        </div>
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><b>Detalhes da Operação</b></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <p>Usuário Responsável: <?php echo $results['usuario']; ?> </p>
              <p>Operação Realizada: <?php echo $results['operpat']; ?> </p>
              <p>Data da Operação: <?php echo date('d/m/Y H:i:s', strtotime($results['data_operpat'])); ?> </p>
              <p>Tipo de Registro: <?php echo $results['tipo_registro']; ?> </p>
              <p>Dados do Registro:</p>
              <?php 
                $registro = json_decode($results['registro'], true);
                
                foreach ($registro as $chave => $valor) {
                    echo $chave . ': ' . $valor;
                    echo '<br/>';
                }
              ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include ('../../layout/footer.html');?>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- page script -->
<script>

 $('').dataTable({
  oLanguage: {
      "sLengthMenu": "Mostrar _MENU_ registros por página",
      "sZeroRecords": "Nenhum registro encontrado",
      "sInfo": "Mostrando _START_ / _END_ de _TOTAL_ registro(s)",
      "sInfoEmpty": "Mostrando 0 / 0 de 0 registros",
      "sInfoFiltered": "(filtrado de _MAX_ registros)",
      "sSearch": "Pesquisar: ",
      "oPaginate": {
          "sFirst": "Início",
          "sPrevious": "Anterior",
          "sNext": "Próximo",
          "sLast": "Último"
      }
  }
});    
</script>
</body>
</html>
