<?php 
session_start();
include '../../utils/bd.php'; 
include '../../utils/valida_login.php';
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
  <style>
    table, th, td {
        border: 1px solid black;
        height: 30px;
        width: 400px;
        text-align: center;
    }
</style>
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
              <h3 class="box-title">Cadastrar Nova Ação</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form role="form" action="../../controllers/acao/new-acao.php" method="post">
              	<div class="col-md-4">
    	        		<div class="form-group">
                        <label>Ação</label>
                        <input type="text" class="form-control" placeholder="Digite a ação" name="nome">
                     </div>
		        </div>
                    
                    <div class="col-md-4">
		        	<div class="form-group">
                  		<label>Função</label>
		                  <select class="form-control" id="funcao" name="funcao">
		                    <option value="">Selecione</option>
                            <?php
                                foreach($conn->query('SELECT * FROM funcao') as $row) {
                                    echo '<option value="'.$row['id'].'">'.$row['nome'].'</option>';
                                }       
                            ?>
		                  </select>
                	</div>
		        </div>
		        <div class="col-md-4">
		        	<div class="form-group">
                  		<label>Subfunção</label>
		                  <select class="form-control" id="subfuncao" name="subfuncao">
		                    <option value="">Selecione</option>
		                  </select>
                	</div>
		        </div>
                <!-- text input -->

                <div class="col-md-2">
                    <div class="form-group">
                        <label>Orgão</label>
                        <select type="text" class="form-control" placeholder="" id="orgao" name="orgao">
                            <option value=""> Selecione </option>
                            <?php
                                foreach($conn->query('SELECT * FROM orgao') as $row) {
                                    echo '<option value="'.$row['id'].'">'.$row['nome'].'</option>';
                                }       
                            ?>
                        </select>
                    </div>
                </div>

                
            <div class="col-md-4">
                <div class="form-group">
                    <label>Unidade Orçamentária</label>
                    <input disabled type="text" class="form-control" placeholder="" id="unidade_orc" name="unidade_orc">
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label>Quantidade Iniciativas</label>
                    <input type="text" class="form-control" placeholder="Digite a quantidade" name="quantidade_iniciativas">
                </div>
            </div> 

            <div class="col-md-3">
                <div class="form-group">
                  <label>Ano</label>
                  <input type="text" class="form-control" placeholder="Digite o ano" id="ano" name="ano">  
		        </div>
            </div>
            <div class="col-md-3 col-md-offset-3">
		        	<div class="form-group">
                  		<label>Período Início</label>
		                <input type="date" class="form-control" name="periodo_inicio">  
                	</div>
                </div>              

                <div class="col-md-3">
		        	<div class="form-group">
                  		<label>Período Fim</label>
		                <input type="date" class="form-control" name="periodo_fim">  
                	</div>
                </div>
                <div class="col-md-3 col-md-offset-2">
                    <div class="form-group">
                        <label>Programa</label>
                        <select class="form-control" name="programa">
                            <option value="">Selecione</option>
                        </select> 
                    </div>
                </div>
                
                <div id="fonte_recurso" class="col-md-6">
                    <table>
                        <tr>
                            <td><b>Fonte do Recurso</b></td>
                            <td><b>Recurso Disponível</b></td>
                        </tr>
                        <tr>
                            <td>Tesouro</td>
                            <td>R$ 1.234,21</td>
                        </tr>
                        <tr>
                            <td>ETC</td>
                            <td>R$ 45.654,62</td>
                        </tr>
                    </table>
                </div>
            <div class="col-md-12">
                <div class="form-group">
                  <label>Objetivo</label>
                  <textarea class="form-control" rows="5" placeholder="" name="objetivo"></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                  <label>Resultado Esperado</label>
                  <textarea class="form-control" rows="5" placeholder="" name="resultado"></textarea>
                </div>
            </div>
            </div>
            
            <div class="box-footer">
              <button type="submit" class="btn btn-success" style="margin-left: 15px">Cadastrar</button>
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
<script src="../../assets/js/jquery.mask.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

<script>
  $(funcao).change(function () {
    var valor = $('#funcao').find(":selected").val();
    
    $.get('../../controllers/subfuncao/lista-subfuncao.php?find=' + valor, function(data) {
        $('#subfuncao').find('option').remove();
        $('#subfuncao').append(data);
    });
  });

  $(orgao).change(function () {
    var valor = $('#orgao').find(":selected").val();
    
    $.get('../../controllers/orgao/lista-unidade-orcamentaria.php?find=' + valor, function(data) {
        $('#unidade_orc').val('');
        $('#unidade_orc').val(data);
    });
  });
</script>
</body>
</html>
