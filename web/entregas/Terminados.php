<?php
session_start();
if(!isset($_SESSION["codigo_usuario"]))
header("Location:http://192.168.0.99/web/ONM/login/acceso.html");
$codtecnico=  $_SESSION["codigo_usuario"];
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>ONM-Listado Terminados</title>
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
		function modificarEstado(coddetalle){
                    var codigotecnico=document.getElementById("Codigo").value;
                    if(codigotecnico=="")
                    {
                        codigotecnico=1;
                    }
                    $.ajax({type: "GET",url:"../class/ClsListadoDetalleEntrega.php",data:"coddetalle="+coddetalle+"&codtecnico="+codigotecnico,success:function(msg){
                    $("#").fadeIn("slow",function(){
                    $("#").html(msg);
                    })}})
                    window.location.reload();    
		};
		function Redirigir(){
			window.location.reload();
		};
                function asignarCodigo(){
                  
                    document.getElementById("Codigo").value =document.getElementById("txtTecnicoA").value;
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
                      <h1 class="page-header">Listado Terminados - <small>ONM WORKFLOW</small></h1>
                </div>	
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                       
                        <div class="panel-heading">
                            Listado de Instrumentos Calibrados
                        </div>
                         <input type="hidden" name='txtCodigo' id='Codigo'>
                        <!-- /.panel-heading -->
                        <form class="form-horizontal"   method="post" role="form" >
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr class="success">
                                            <th>Codigo</th>
											 <th>Cliente</th>
                                            <th>Instrumento</th>
                                             <th>Observación</th>
                                            <th>Fecha Entrega</th>
                                            <th>Situacion</th>
                                            <th>Entregado por..</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    <?php
                    $query = "select ingdet.ing_coddet,cli.cli_nom||' '||cli.cli_ape as cliente,ingdet.ing_obs,ingdet.ing_cant,ins.ins_nom,to_char(ing.fecha_entrega,'DD/MM/YYYY') as 
                            fecha_entrega,ingdet.situacion 
                            from tecnicos_laboratorios teclab,tecnicos tec,ingreso ing, ingreso_detalle ingdet, clientes cli,
                            laboratorios lab, instrumentos ins
                            where ins.lab_cod=lab.lab_cod 
                            and  teclab.lab_cod=lab.lab_cod 
                            and teclab.tec_cod=tec.tec_cod 
                            and ing.ing_cod=ingdet.ing_cod
                            and ingdet.ins_cod=ins.ins_cod
							and cli.cli_cod=ing.cli_cod
                            and ingdet.situacion='TERMINADO'
                            and tec.tec_cod=$codtecnico order by fecha_entrega desc";
                    $result = pg_query($query) or die ("Error al realizar la consulta");
                    while($row1 = pg_fetch_array($result))
                    {
                        echo "<tr><td>".$row1["ing_coddet"]."</td>";
						echo "<td>".$row1["cliente"]."</td>";
                        echo "<td>".$row1["ins_nom"]."</td>";
                        echo "<td>".$row1["ing_obs"]."</td>";
                        echo "<td>".$row1["fecha_entrega"]."</td>";
                        echo "<td>".$row1["situacion"]."</td>";
                        echo '<td><select onChange="asignarCodigo()" name="txtTecnicoA" class="form-control" id="txtTecnicoA" required>';
                        //esto es para mostrar un select que trae datos de la BDD
                        conexionlocal();
                        $query = "Select tec_cod,tec_nom||' '|| tec_ape from tecnicos where estado='t'";
                        $resultadoSelect = pg_query($query);
                        while ($row = pg_fetch_row($resultadoSelect)) {
                            echo "<option value=" . $row[0] . ">";
                            echo $row[1];
                            echo "</option>";
                                                    }
                            echo '</select></td><td onclick="javascript:location.reload()">';
                            ?>
                            <a onclick="modificarEstado(<?php echo $row1['ing_coddet'];?>)" class="btn btn-success btn-xs active" data-toggle="modal" data-target="#modalprueba" role="button">Asignar</a>
                            <?php    
                            echo "</td></tr>";}
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