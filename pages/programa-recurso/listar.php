<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

$programa = $_GET['programa'];

$stmt_programa = $conn->prepare("SELECT * FROM programa WHERE id = :id;");

$stmt_programa->bindParam(':id', $programa);
$stmt_programa->execute();

$row_programa = $stmt_programa->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT f.id as fonte_recurso_id, f.nome AS fonte, 
                          p.nome as programa, f.valor AS recurso_total,
                          pf.valor AS recurso_alocado 
                          FROM programa_has_fonte_recurso pf
                          INNER JOIN programa p ON p.id = pf.programa_id
                          INNER JOIN fonte_recurso f ON f.id = pf.fonte_recurso_id
                          WHERE pf.programa_id = :programa;");

$stmt->bindParam(':programa', $programa);
$stmt->execute();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sys-PAT</title>
  <link href="/e-conv/imagens/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
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
          <a href="novo.php?programa=<?=$programa?>" class="btn btn-success" style="margin-bottom: 20px; margin-top: 20px"><i class= "fa fa-plus-square"></i> </a>
        </div>
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><b>Listagem - Alocação de Recursos</b></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <h4 class="box-title"><b>Programa: <?php echo $row_programa['nome']?></b></h4>
              <table id="tabela" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="text-align: center">Fonte</th>
                  <th style="text-align: center">Recurso Total</th>
                  <th style="text-align: center">Recurso Alocado</th>
                  <th style="text-align: center">Opções</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                  
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                      $fonte_recurso_id = $row['fonte_recurso_id'];
                      echo '<tr>';
                        echo "<td align='center'>" . $row['fonte'] . '</td>';
                        echo "<td align='center'>" . $row['recurso_total'] . '</td>';
                        echo "<td align='center'>" . $row['recurso_alocado'] . '</td>';
                        echo "<td align='center'>" . "<a href='../../controllers/programa-recurso/excluir.php?programa=$programa&fonte-recurso=$fonte_recurso_id' class='btn btn-danger'><i class='fa fa-trash'></i></a>";
                        echo "&nbsp&nbsp". "<a href='editar.php?programa=$programa&fonte-recurso=$fonte_recurso_id' class='btn btn-default'><i class='fa fa-edit'></i></a>";
                      echo '</tr>';
                    }
                  ?>
                </tbody>
              </table>
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