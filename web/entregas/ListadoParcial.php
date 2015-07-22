<?php
session_start();
if(!isset($_SESSION['codigo_usuario']))
header("Location:http://192.168.0.99/web/ONM/login/acceso.html");
$catego=  $_SESSION["categoria_usuario"];
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ONM-Entrega Parcial</title>
    <!-- Bootstrap Core CSS -->
    <link href="../../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- MetisMenu CSS -->
    <link href="../../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	<!-- DataTables CSS -->
    <link href="../../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="../../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../../dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="../../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- jQuery -->
    <script src="../../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../bower_components/metisMenu/dist/metisMenu.min.js"></script>
	
    <!-- DataTables JavaScript -->
    <script src="../../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
	    
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
			responsive: true
        });
    });
    </script>
    <script type="text/javascript">
		function asignarCodigo(codigo){
                    document.getElementById('idCodigo').value=codigo;
		};
	</script>	
</head>

<body>

    <div id="wrapper">

        <?php 
        include("../funciones.php");
        include("../menu.php");
        conexionlocal();
        ?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                      <h1 class="page-header">Listado Entrega - <small>ONM WORKFLOW</small></h1>
                </div>	
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Listado de Entregas
                        </div>
                        <!-- /.panel-heading -->
                        <form class="form-horizontal" action="ListadoDetalle.php"  method="post" role="form" >
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <input  type="hidden" name="txtCodigo" id="idCodigo" required>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr class="success">
                                            <th>Codigo</th>
                                            <th>Proforma</th>
                                            <th>Cliente</th>
                                            <th>Observacion</th>
                                            <th>Fecha Recepcion</th>
                                            <th>Fecha Entrega</th>
                                            <th>Estado</th>
                                            <th>Detalle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    <?php
                    $query = "select distinct(ing.ing_cod),ing.ing_proforma,ing.cli_cod,cli.cli_nom || ' '|| cli.cli_ape as nombres,
                    to_char(ing.fecha_recepcion,'DD/MM/YYYY') as fecha_recepcion,to_char(ing.fecha_entrega,'DD/MM/YYYY') as fecha_entrega,ing.estado,ing.situacion,ing.ing_obs 
                    from ingreso ing,ingreso_detalle ingdet, clientes cli
                    where cli.cli_cod=ing.cli_cod and ingdet.ing_cod=ing.ing_cod and ingdet.situacion='A ENTREGAR'";
                    $result = pg_query($query) or die ("Error al realizar la consulta");
                    while($row1 = pg_fetch_array($result))
                    {
                        $estado=$row1["estado"];
                        if($estado=='t'){$estado='Activo';}else{$estado='Inactivo';}
                        echo "<tr><td>".$row1["ing_cod"]."</td>";
                        echo "<td>".$row1["ing_proforma"]."</td>";
                        echo "<td>".$row1["nombres"]."</td>";
                        echo "<td>".$row1["ing_obs"]."</td>";
                        echo "<td>".$row1["fecha_recepcion"]."</td>";
                        echo "<td>".$row1["fecha_entrega"]."</td>";
                        echo "<td>".$estado."</td>";
                        echo "<td>";?>
                        <button onclick="asignarCodigo(<?php echo $row1["ing_cod"]; ?>)" type="submit" name="modificar" class="btn btn-primary">Ver Detalles</button>
                        <?php
                        echo "</td></tr>";
                    }
                    pg_free_result($result);
                    ?>
                                    </tbody>
                                </table>
                            </div>		
                        </div>
                       </form>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
 
</html>