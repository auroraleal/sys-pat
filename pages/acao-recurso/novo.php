<?php 
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php'; 

$acao = $_GET['id'];

$stmt = $conn->prepare("SELECT a.id, a.nome, a.ano, p.nome as programa FROM acao a
                          INNER JOIN programa p ON p.id = a.programa_id
                        WHERE a.id = :id;");

$stmt->bindParam(':id', $acao);
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
              <h3 class="box-title">Alocação de Recursos</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="../../controllers/acao-recurso/new_tipo.php" method="post">
            <div class="box-body">
            <input type="hidden" name= "acao_id" value="<?=$acao?>">
            <h4 class="box-title"><b>Programa:</b> <?php echo $row['programa']?></h4>
            <h4 class="box-title"><b>Ação:</b> <?php echo $row['nome']?></h4>
            <br>
            <div class="col-md-4">
              <div class="form-group">
                <label>Fonte</label>
                <select type="text" class="form-control" placeholder="" id="fonte" name="fonte">
                  <option value=""> Selecione </option>
                  <?php
                      foreach($conn->query('SELECT id, nome FROM fonte_recurso') as $row) {
                          echo '<option value="'.$row['id'].'">'.$row['nome'].'</option>';
                      }       
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                  <label>Valor Total (R$)</label>
                  <input disabled type="text" id="valor_total" name= "valor_total" class="form-control money" placeholder="">
                </div>
            </div>
            
</div>
            <div class="box-footer">
              <button type="submit" class="btn btn-success" style="margin-left: 15px">Cadastrar</button>
            </div>

</form>
</div>
</div>
</div>
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
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script>
  $(document).ready(function () {
    $('.sidebar-menu').tree();
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
  });

  $(fonte).change(function () {
    var valor = $('#fonte').find(":selected").val();
    
    $.get('../../controllers/programa-recurso/lista-valor-total.php?find=' + valor, function(data) {
        $('#valor_total').val('');
        $('#valor_total').val(data);
    });
  });
</script>
</body>
</html>
