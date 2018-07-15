<?php 
session_start();
include '../../utils/bd.php'; 
include '../../utils/valida_login.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM convenios WHERE id = $id");

try
{
	$stmt->execute();
  $results = $stmt->fetch(PDO::FETCH_ASSOC);
  
  $data_inicio = date('d/m/Y', strtotime($results['inicio']));
  $data_termino = date('d/m/Y', strtotime($results['termino']));
  $valor_global = number_format($results['valor_global'], 2, ',', '.');
  $valor_repasse = number_format($results['valor_repasse'], 2, ',', '.');
  $valor_contrapartida = number_format($results['valor_contrapartida'], 2, ',', '.');
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
	        <!-- left column -->

    	<div style="margin-left: 100px" class="col-md-10">
          <!-- general form elements -->
            
   			<div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Convênio</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" action="../../controllers/acoes/editar.php" method="post">
                <input type="hidden" name="id" value="<?=$id?>"/>
              	<div class="col-md-4">
    	        		<div class="form-group">
                		<label>Secretaria Responsável</label>
	                  <select  class="form-control" name="secretaria">
                      <option value="">Selecione</option>
                      <?php
                          foreach($conn->query('SELECT * FROM secretaria') as $row) {
                              if ($row['id'] == $results['secretaria_id']) {
                                echo '<option selected value="'.$row['id'].'">'.$row['nome'].'</option>';
                              } else {
                                echo '<option value="'.$row['id'].'">'.$row['nome'].'</option>';                                 
                              }  
                          }       
                      ?>
	                    
	                  </select>
            	     </div>
		            </div>
		        <div class="col-md-2">
		        	<div class="form-group">
                  		<label>Ano</label>
                  		<input type="text"  value="<?=$results['ano']?>" class="form-control" placeholder="Digite o Ano" name="ano">
                	</div>
		        </div>
		        <div class="col-md-4">
		        	<div class="form-group">
                  		<label>Orgão</label>
		                  <select class="form-control" name="orgao" >
		                    <option value="">Selecione</option>
                      <?php
                          foreach($conn->query('SELECT * FROM orgao') as $row) {
                              if ($row['id']==$results ['orgao_id']){
                                echo '<option selected value="'.$row['id'].'">'.$row['nome'].'</option>';
                              } else {
                                echo '<option value="'.$row['id'].'">'.$row['nome'].'</option>';
                              }
                              
                          }       
                      ?>
		                  </select>
                	</div>
		        </div>
                <!-- text input -->

          <div class="col-md-2">
          <div class="form-group">
            <label>Numero orgão</label>
            <input type="text" class="form-control"  placeholder="" name="numero_orgao" value="<?=$results['numero_orgao']?>">
          </div>

            </div>

                <div class="col-md-2">
		        	<div class="form-group">
                  		<label>Início</label>
		                <input type="text" class="form-control date"  placeholder="" name="inicio" value="<?=$data_inicio?>">
                	</div>
		        </div>

		        <div class="col-md-2">
		        	<div class="form-group">
                  		<label>Término</label>
		                <input type="text"  value= "<?=$data_termino?>"class="form-control date" placeholder="" name="termino">
                	</div>
		        </div>

                <!-- textarea -->
                
        <div class="col-md-2">
                <div class="form-group">
                  <label>Numero SINCOV</label>
                  <input type="text" class="form-control"  placeholder="" name="numero_sincov" value="<?=$results['numero_sincov']?>">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                  <label>Numero convênio</label>
                  <input type="text" class="form-control"  placeholder="" name="num_convenio" 
                  value="<?=$results['numero']?>">
                </div>
            </div>


              <div class="col-md-2">
                <div class="form-group">
                  <label>Empenhado</label>
                  <select class="form-control" name="empenhado" >
                      <option value="">Selecione</option>
                      <option <?php if ($results['empenhado'] == 'Sim') echo 'selected' ?> value="Sim">Sim</option>
                      <option <?php if ($results['empenhado'] == 'Não') echo 'selected' ?> value="Não">Não</option>
                      <option <?php if ($results['empenhado'] == 'Não Informado') echo 'selected' ?> value="Não Informado">Não Informado</option>                      
                  </select>
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                  <label>Termo Convênio</label>
                  <select class="form-control" name="termo" >
                      <option value="">Selecione</option>
                      <option <?php if ($results['termo_convenio'] == 'Sim') echo 'selected' ?> value="Sim">Sim</option>
                      <option <?php if ($results['termo_convenio'] == 'Não') echo 'selected' ?> value="Não">Não</option>
                      <option <?php if ($results['termo_convenio'] == 'Não Informado') echo 'selected' ?> value="Não Informado">Não Informado</option>
                  </select>
                </div>
                </div>

            <div class="col-md-2">
                <div class="form-group">
                  <label>Repasse (%)</label>
                  <input type="text" class="form-control"  placeholder=" ex.:10" name="repasse" 
                  value="<?=$results['repasse']?>">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                  <label>Contrapartida (%)</label>
                  <input type="text" class="form-control"  placeholder="ex.:10" name="contrapartida" value="<?=$results['contrapartida']?>">
                </div>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                  <label>Ação</label>
                 <select class="form-control" name="pat" >
                        select class="form-control" name="pat">
                      <option value="">Selecione</option>
                      <?php
                          foreach($conn->query('SELECT * FROM pat') as $row) {
                            if ($row['id']==$results ['pat_id']){
                                echo '<option selected value="'.$row['id'].'">'.$row['pat'].'</option>';
                              } else {
                              echo '<option value="'.$row['id'].'">'.$row['pat'].'</option>';
                          }      
                        } 
                      ?>
                      </select> 
                </div>
            </div>
                <div class="col-md-3">
                <div class="form-group">
                  <label>Status</label>
                   <select class="form-control" name="status" >
                         <option value="">Selecione</option>
                      <?php
                          foreach($conn->query('SELECT * FROM status') as $row) {
                            if ($row['id']==$results ['status_id']){
                                echo '<option selected value="'.$row['id'].'">'.$row['status'].'</option>';
                              } else {
                              echo '<option value="'.$row['id'].'">'.$row['status'].'</option>';
                          }     
                        }  
                      ?>
                      </select>
               </div>
               </div>

        <div class="col-md-3">
                <div class="form-group">
                  <label>Origem</label>
                  <select type="text" class="form-control" placeholder="" name="origem">
                  <option value=""> Selecione </option>
                  <?php
                  foreach($conn->query('SELECT * FROM origem') as $row) {
                    if ($row['idorigem'] == $results['origem_id']){
                      echo '<option selected value="'.$row['idorigem'].'">'.$row['nome'].'</option>';
                    } else {
                      echo '<option value="'.$row['idorigem'].'">'.$row['nome'].'</option>';
                    }
                }       
            ?>
            </select>
                </div>
                </div>

            <div class="col-md-3">
                <div class="form-group">
                  <label>Tipo de convênio</label>
                  <select class="form-control" name="tipo_convenio_id" >
                         <option value="">Selecione</option>
                      <?php
                          foreach($conn->query('SELECT * FROM tipo_convenio') as $row) {

                            if ($row['id']==$results ['tipo_convenio_id']){
                                echo '<option selected value="'.$row['id'].'">'.$row['tipo'].'</option>';
                              } else {
                              echo '<option value="'.$row['id'].'">'.$row['tipo'].'</option>';
                            }       
                        }
                      ?>
                    </select>
                </div>
           </div>

        <div class="col-md-3">
                <div class="form-group">
                  <label>Valor global</label>
                  <input type="text" class="form-control money"  placeholder="" name="valor_global" value="<?=$valor_global?>">
                </div>
        </div>

            <div class="col-md-3">
                <div class="form-group">
                  <label>Valor Repasse</label>
                  <input type="text" class="form-control money"  placeholder="" name="valor_repasse" value="<?=$valor_repasse?>">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                  <label>Valor contrapartida</label>
                  <input  type="text" class="form-control money"  placeholder="" name="valor_contrapartida" value="<?=$valor_contrapartida?>">
                </div>
            </div>


            <div class="col-md-12">
                <div class="form-group">
                  <label>Objeto</label>
                  <textarea class="form-control" rows="3" placeholder="texto" name="objeto" ><?=$results['objeto']?></textarea>
                </div>
            </div>

            
				<div class="col-md-12">
                <div class="form-group">
                  <label>Situação</label>
                  <textarea class="form-control" rows="3" placeholder="texto" name="situpat" ><?=$results['situpat']?></textarea>
                </div>
        </div>
        </div>
            <div class="box-footer">
              <button type="submit" class="btn btn-success" style="margin-left: 15px">Salvar</button>
            </div>

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

<!-- AdminLTE App -->
<!-- AdminLTE for demo purposes -->
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
 ?>