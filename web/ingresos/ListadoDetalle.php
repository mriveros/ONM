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

    <title>ONM-Listado Detalle</title>
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
    
    </script>
	<script type="text/javascript">
		function modificarEstado(coddetalle){
                    var codigotecnico=document.getElementById("Codigo").value;
                    if(codigotecnico=="")
                    {
                        codigotecnico=1;
                    }
                    $.ajax({type: "GET",url:"../class/ClsListadoDetalle.php",data:"coddetalle="+coddetalle+"&codtecnico="+codigotecnico,success:function(msg){
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
        <?php 
        include("../funciones.php");
        include("../menu.php");
        conexionlocal();
        ?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="row" >
                <div class="col-lg-12">
                      <h1 class="page-header">Listado Detalle</h1>
                </div>	
            </div>
            <input type="hidden" name='txtCodigo' id='Codigo'>
            <!-- /.row -->
            <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                Listado de Instrumentos
                                            </div>
                                            <!-- /.panel-heading -->
                                          
                                            <div class="panel-body" >
                                                <div class="dataTable_wrapper" >
                                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                                        <thead>
                                                            <tr class="success">
                                                                <th>Codigo</th>
                                                                <th>Instrumento</th>
                                                                <th>Laboratorio</th>
                                                                <th>Fecha Entrega</th>
                                                                <th>Estado</th>
                                                                <th>Asignar a..</th>
                                                                <th>Accion</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                        <?php
                                        if  (empty($_POST['txtCodigo'])){$codigo=0;}else{ $codigo = $_POST['txtCodigo'];}
                                        $query = "select ingdet.ing_coddet, ing.ing_cod,lab.lab_nom, ins.ins_cod,ins.ins_nom,ins.ins_des,lab.lab_nom,to_char(ins.fecha,'DD/MM/YYYY')as fecha,ins.estado 
                                        from instrumentos ins, laboratorios lab,ingreso ing,ingreso_detalle ingdet 
                                        where ins.lab_cod=lab.lab_cod  and ing.ing_cod=ingdet.ing_cod
                                        and ingdet.ins_cod=ins.ins_cod and ing.ing_cod=$codigo and ingdet.situacion='RECEPCION'" ;
                                        $result = pg_query($query) or die ("Error al realizar la consulta");
                                        while($row1 = pg_fetch_array($result))
                                        {
                                            $estado=$row1["estado"];
                                            if($estado=='t'){$estado='Activo';}else{$estado='Inactivo';}
                                            echo "<tr><td>".$row1["ing_coddet"]."</td>";
                                            echo "<td>".$row1["ins_nom"]."</td>";
                                            echo "<td>".$row1["lab_nom"]."</td>";
                                            echo "<td>".$row1["fecha"]."</td>";
                                            echo "<td>".$estado."</td>";
                                              
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
                                                        <a onclick="modificarEstado(<?php echo $row1['ing_coddet'];?>)" class="btn btn-success btn-xs active" data-toggle="modal" data-target="#modalprueba" role="button">Enviar a Area Tecnica</a>
                                        <?php    
                                            echo "</td></tr>";}
                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>		
                                            </div>
                                            <!-- /.panel-body -->
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    <!-- /.col-lg-12 -->
                                </div>	
            <!-- /.row -->
            
        </div>
        <!-- /#page-wrapper -->
    <!-- /#wrapper -->
</html>