<?php
session_start();
include '../../utils/bd.php';
include '../../utils/valida_login.php';

$stmt = $conn->prepare("SELECT * FROM acao;");

$stmt->execute();

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sys-PAT</title>
  <link href="/sys-pat/imagens/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="/e-conv/assets/css/dataTables.jqueryui.css">
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
              <a href="nova.php" class="btn btn-success" style="margin-bottom: 20px; margin-top: 20px"><i class= "fa fa-plus-square"></i> </a>
            </div>
            <!-- /.box-header -->
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title"><b>Lista de Ações</b></h3>
                <p style="margin-top: 10px"><b>Total: <?php echo $stmt->rowCount(); ?> registro(s)</b></p>
              </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tabela" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="text-align: center">Ação</th>
                  <th style="text-align: center">Ano</th>
                  <th style="text-align: center">Opções</th>
          
                </tr>
                </thead>
                <tbody>
                  <?php
                  
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                    {
                      $id = $row['id'];
                      $nome = $row['nome'];
                      echo '<tr>';
                      echo "<td align='center'>" . $row['nome'] .'</td>';
                      echo "<td align='center'>" . $row['ano'] . '</td>';
                  ?>
                  <td align='center'><a onclick="return confirm('Deseja realmente excluir?');" href='../../controllers/acao/excluir.php?id=<?=$id?>' class='btn btn-danger'><i class='fa fa-trash'></i></a>
                  <?php     
                        //echo "&nbsp&nbsp" . "<a href='editar.php?id=$id' class='btn btn-default'><i class='fa fa-edit'></i></a>" . '&nbsp&nbsp';
                        echo "&nbsp&nbsp" . "<a href='#' class='btn btn-default'><i class='fa fa-edit'></i></a>" . '&nbsp&nbsp';
                        echo "<a href='#' class='btn btn-info'><i class='fa fa-eye'></i></a>";
                      //echo "<a href='visualizar.php?id=$id' class='btn btn-info'><i class='fa fa-eye'></i></a>";
                      //echo "&nbsp&nbsp" . "<a href='/sys-pat/pages/iniciativa/nova.php?id=$id&nome=$nome' title='Iniciativas' class='btn btn-default'><i class='fa fa-folder-o'></i></a>";
                      echo "&nbsp&nbsp" . "<a href='/sys-pat/pages/iniciativa/nova.php?id=$id' title='Iniciativas' class='btn btn-success'><i class='fa fa-folder-o'></i></a>";
                      echo '</td>';
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
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->

<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.colVis.min.js"></script>
<!-- page script -->
<script>
    $('#tabela').dataTable({
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
    },
    dom: 'Bfrtip',
    buttons: [
      {
        extend:    'excelHtml5',
        exportOptions: {
          columns: [ 0, 1, 2,3 ]
        },
        text:      '<i class="fa fa-file-excel-o"></i>',
        titleAttr: 'Exportar - Excel'
      },
      {
        extend:    'pdfHtml5',
        exportOptions: {
          columns: [ 0, 1, 2, 3 ]
        },
        orientation: 'portrait',
        text:      '<i class="fa fa-file-pdf-o"></i>',
        download: 'open',
        titleAttr: 'Exportar - PDF',
        customize: function ( doc ) {
          doc['styles'] = {
            userTable: {
              margin: [0, 15, 0, 15]
            },
            tableHeader: {
              bold:!0,
              fontSize:11,
              color:'white',
              fillColor:'#00a65a',
              alignment:'center'
            }
          };
          doc.footer = (function(page, pages) {
            // Obtém a data/hora atual
            var data = new Date();
            // Guarda cada pedaço em uma variável
            var dia     = data.getDate();           // 1-31
            var mes     = data.getMonth();          // 0-11 (zero=janeiro)
            var ano4    = data.getFullYear();       // 4 dígitos
            var hora    = data.getHours();          // 0-23
            var min     = data.getMinutes();        // 0-59
            var seg     = data.getSeconds();        // 0-59
            // Formata a data e a hora (note o mês + 1)
            dia < 10 ? dia = '0' + dia : '';
            
            mes++;
            mes < 10 ? mes = '0' + mes : '';
            hora < 10 ? hora = '0' + hora : '';
            min < 10 ? min = '0' + min : '';
            seg < 10 ? seg = '0' + seg : '';
            var str_data = dia + '/' + mes + '/' + ano4 + ' - '+ hora + ':' + min + ':' + seg;
            return {
              columns: [
                'Emitido em: ' + str_data,
                {
                  alignment: 'center',
                  text: [
                    { text: 'Página ' + page.toString(), italics: true },
                    ' de ',
                    { text: pages.toString(), italics: true }
                  ]
                }
              ],
              margin: [10, 0]
            }
          });
          doc.content.splice( 1, 0, {
            margin: [ 0, 0, 0, 12 ],
            alignment: 'center',
            image : 'data:image/png;base64,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'
          });
        }            
      }
      /*{
        extend: 'colvis',
        text: 'Exibir/Ocultar colunas'
      },*/
    ],
    columnDefs: [ {
        visible: false
    } ]

});
</script>
</body>
</html>