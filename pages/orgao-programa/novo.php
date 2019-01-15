<?php 
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php'; 

$orgao_id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM orgao WHERE id = $orgao_id");
$stmt_programas_vinculados = $conn->prepare("SELECT  o.id as orgao_id, p.id as programa_id, 
                                                     p.nome as nome_programa 
                                             FROM programa_has_orgao po
                                              INNER JOIN programa p
                                                ON po.programa_id = p.id
                                              INNER JOIN orgao o
                                                ON po.orgao_id = o.id
                                             WHERE o.id = $orgao_id");

try
{
  $stmt->execute();
  $stmt_programas_vinculados->execute();
  $results = $stmt->fetch(PDO::FETCH_ASSOC);
}
catch(PDOException $e)
{
  $_SESSION['erro'] = "Erro: " . $e->getMessage();
}
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
    table, th, td {
        border: 1px solid black;
        height: 30px;
        width: 400px;
        text-align: center;
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
              <h3 class="box-title">Vinculação: Orgão / Programa</h3>
            </div>
            <!-- /.box-header -->
            <form role="form" action="../../controllers/orgao-programa/new.php" method="post">
              <input type="hidden" value="<?=$orgao_id?>" name="orgao"/>
            <div class="box-body">
            <div id="orgao" class="col-md-10 form-cadastro" style="margin-bottom: 20px">
              <h5>Órgão: <b><?php echo $results['nome']?></b></h5>
            </div>
            <div class="col-md-3">
              <div class="form-group">
                  <label>Programa</label>
                  <select class="form-control" id="programa" name="programa">
                      <option value="">Selecione</option>
                      <?php
                          foreach($conn->query('SELECT * FROM programa') as $row) {
                              echo '<option value="'.$row['id'].'">'.$row['nome'].'</option>';
                          }       
                      ?>
                  </select> 
              </div>
            </div>
                          
            <div id="fonte_recurso" class="col-md-6">
                <table>
                    <tr>
                        <td><b>Fonte do Recurso</b></td>
                        <td><b>Dotação Inicial (R$)</b></td>
                   </tr>
                </table>
            </div>

            <div id="orgao" class="col-md-10 form-cadastro" style="margin-top: 10px"> 

              <h4><b>Programas Vinculados</b></h4>
              <hr/>
              <table id="tabela" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="text-align: center">Programa</th>
                  <th style="text-align: center">Opções</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    while ($row = $stmt_programas_vinculados->fetch(PDO::FETCH_ASSOC))
                    {
                      $nome_programa = $row['nome_programa'];
                      $orgao_id    = $row['orgao_id'];
                      $programa_id = $row['programa_id'];
                      echo '<tr>';
                        echo "<input type='hidden' value='$nome_programa' id='nome_programa'/>";
                        echo "<input type='hidden' value='$programa_id' id='programa_id'/>";
                        echo "<td align='center'>" . $nome_programa . '</td>';
                        echo "<td align='center'>";
                        ?>
                          <a href='#' id='btn_detalhes' data-toggle='modal' data-target='#myModal' class='btn btn-info' title='Detalhes'><i class='fa fa-eye'></i></a>&nbsp&nbsp
                          <a onclick="return confirm('Deseja realmente desvincular programa?');" href='../../controllers/orgao-programa/excluir.php?orgao=<?=$orgao_id?>&programa=<?=$programa_id?>' class='btn btn-danger'><i class='fa fa-trash'></i></a>
                      <?php                          
                        echo '</td>';
                      echo '</tr>';
                    }
                  ?>
                </tbody>
              </table>
            </div>
</div>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Detalhes do Programa</h4>
        </div>
        <div class="modal-body" style="margin-left: 80px">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
        </div>
      </div>

    </div>
</div>
            <div class="box-footer">
              <button type="submit" class="btn btn-success" style="margin-left: 15px">Vincular</button>
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

    <!-- Modal -->
  
  </div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
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
    $('.sidebar-menu').tree()
  })

  $(programa).change(function () {
    var valor = $('#programa').find(":selected").val();
    
    $.get('../../controllers/programa-recurso/lista-recursos-programa.php?find=' + valor, function(data) {
        $('#fonte_recurso').empty();
        $('#fonte_recurso').append(data);
    });
  });

  $(btn_detalhes).click(function () {
      var nome_programa = $('#nome_programa').val();
      var valor = $('#programa_id').val();

      $('.modal-body').html('carregando...');
      $('.modal-body').html('<h4><b>Programa: </b>' + nome_programa + '</h4>');
      $('.modal-body').append('<br>');
      $.ajax({
      type: 'GET',
      url: '../../controllers/programa-recurso/lista-recursos-programa.php?find=' + valor,
      success: function(data) {
        $('.modal-body').append(data);
      },
      error:function(err){
        alert("error"+JSON.stringify(err));
      }
      });
  });
</script>
</body>
</html>
