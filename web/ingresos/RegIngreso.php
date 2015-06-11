<?php
session_start();
if(!isset($_SESSION['codigo_usuario']))
header("Location:http://localhost/app/PhpEventos/login/acceso.html");
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

    <title>ONM- Instrumentos</title>
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
	<!-- agregado ultimo -->
   
    <script href="ajaxjquery.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
			responsive: true
        });
    });
    </script>
	<script>
            //Enviar datos por AJAX y cargar
            function Registrar(){
                var proforma=document.getElementById("idProforma").value;
                var cliente=document.getElementById("idCliente").value;
                var fechaentrega=document.getElementById("idEntrega").value;
                var obs=document.getElementById("idObs").value;
                if(proforma=="" || fechaentrega=="" || obs=="")
                {
                    alert('Debe rellenar todos los campos');
                     location.reload(true);
                }else{
                    $.ajax({type: "GET",url:"../class/ClsIngresos.php",data:"proforma="+proforma+"&cliente="+cliente+"&fechaentrega="+fechaentrega+
                    "&obs="+obs,success:function(msg){
                    $("#").fadeIn("slow",function(){
                    $("#").html(msg);
                    })}})
                }
            }
            function Cancelar(){
                window.location="http://localhost/app/ONM/web/menu.php";
            }
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
                      <h1 class="page-header">Instrumentos - <small>ONM WORKFLOW</small></h1>
                </div>	
            </div>
            <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" name="ingresos" id="ingresos" onsubmit="Registrar()">
                                        <div class="form-group">
                                            <label>Proforma</label>
                                            <input type="number" name="txtProformaA" id="idProforma" class="form-control" placeholder="Ingrese numero de Proforma" required>
                                        </div>
                                       <div class="form-group">
                                            <label  class="col-sm-2 control-label" for="input01">Cliente</label>
                                            <div class="form-group">
                                            <select name="txtClienteA" class="form-control" id="idCliente" required>
                                                <?php
                                                //esto es para mostrar un select que trae datos de la BDD
                                                conexionlocal();
                                                $query = "Select cli_cod,cli_nom ||' '|| cli_ape from clientes where estado='t' ";
                                                $resultadoSelect = pg_query($query);
                                                while ($row = pg_fetch_row($resultadoSelect)) {
                                                echo "<option value=".$row[0].">";
                                                echo $row[1];
                                                echo "</option>";
                                                }
                                                ?>
                                            </select>
                                            </div>
					</div>
                                        <div class="form-group">
                                            <label>Fecha Entrega</label>
                                            <input type="date" name="txtEntregaA" id="idEntrega" class="form-control" required>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label>Observacion</label>
                                            <textarea name="txtObsA" id="idObs" class="form-control" rows="3" required></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <a onclick="Registrar()" class="btn btn-success btn-xs active" data-toggle="modal" data-target="#modalprueba" role="button">Agregar Detalle</a>
                                            <a onclick="Cancelar()" class="btn btn-danger btn-xs active" data-toggle="modal" data-target="#modalbor" role="button">Ir a menu</a>
					</form>
                                        </div>
                                    </form>
                                </div> 
                            </div>
                        </div>
            
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- /#MODAL MODIFICACIONES -->
    <div class="modal fade" id="modalprueba" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <embed wmode="transparent" src="IngDetalle.php" width="500" height="400" />
        </div>
    </div>
    </div>
	
    
</html>