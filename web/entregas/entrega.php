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

    <title>ONM- Entregas</title>
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
		function tuhermana(value){
			$('tr').click(function() {
			indi = $(this).index();
			var pdatuno=document.getElementById("dataTables-example").rows[indi+1].cells[1].innerText;
			var pdatdos=document.getElementById("dataTables-example").rows[indi+1].cells[2].innerText;
			document.getElementById("input0").value = value;
			document.getElementById("input1").value = pdatuno;
			document.getElementById("input2").value = pdatdos;
			});
		};
		function tuhermanastra(value){
			document.getElementById("input00").value = value;
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
                    <h1 class="page-header">Entregas - <small>ONM WORKFLOW</small></h1>
                </div>
				
	<?php
            if(isset($_POST['agregar'])){
            $res = mysql_query("SELECT MAX(dep_cod) AS ultimo FROM dependencia");
            if ($row = mysql_fetch_row($res)) {
                $ultimos = trim($row[0]);
                $ultimo=$ultimos+1;
            }
            mysql_query("INSERT INTO dependencia (dep_cod,dep_des,dep_sig,dep_est) VALUES($ultimo,'$_POST[descrip1]','$_POST[descrip2]','$_POST[opcion1]')");
            }
            if(isset($_POST['modificar'])){
                if(!empty($_POST['descrip1'])){
                mysql_query("UPDATE dependencia SET dep_des= '$_POST[descrip1]',dep_sig= '$_POST[descrip2]',dep_est='$_POST[opcion1]' WHERE dep_cod='$_POST[codigo1]'");
                }}
            if(isset($_POST['borrar'])){
                mysql_query("DELETE FROM dependencia WHERE dep_cod='$_POST[codigo1]'");
                header("location:abmdependencia.php");
	}
	$query = "select * from usuario;";
        $result = pg_query($query) or die ("Error al realizar la consulta");
	?>
			
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Listado de Entregas 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr class="success">
                                            <th>Código</th>
                                            <th>Descripción</th>
                                            <th>Sigla</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    <?php
                    while($row1 = pg_fetch_array($result))
                    {
                        echo "<tr><td>".$row1["usu_cod"]."</td>";
                        echo "<td>".$row1["usu_nom"]."</td>";
                        echo "<td><b>".$row1["usu_ape"]."</b></td>";
                        echo "<td>".$row1["usu_username"]."</td>";
                        echo "<td>";?>
                        <a onclick='tuhermana(<?php echo $row1["usu_cod"];?>)' class="btn btn-default btn-xs active" data-toggle="modal" data-target="#modalagr" role="button">Nuevo</a>
                        <a onclick='tuhermana(<?php echo $row1["usu_cod"];?>)' class="btn btn-success btn-xs active" data-toggle="modal" data-target="#modalmod" role="button">Modificar</a>
                        <a onclick='tuhermanastra(<?php echo $row1["usu_cod"];?>)' class="btn btn-danger btn-xs active" data-toggle="modal" data-target="#modalbor" role="button">Borrar</a>
                        <?php
                        echo "</td></tr>";
                    }
                    pg_free_result($result);
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

    </div>
    <!-- /#wrapper -->
	<!-- /#MODAL AGREGACIONES -->
	<div class="modal fade" id="modalagr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header"><button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h3 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-floppy-disk"></i> Agregar Registro</h3>
				</div>
            
				<!-- Modal Body -->
				<div class="modal-body">
					<form class="form-horizontal" name="agregarform" action="" onsubmit="return submitForm();" method="post" role="form">
						<div class="form-group">
							<input type="numeric" name="codigo1" class="hide" id="input000" />
							<label  class="col-sm-2 control-label" for="input01">Descripción</label>
							<div class="col-sm-10"><input type="text" name="descrip1" class="form-control" id="input01" placeholder="Descripción" required /></div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label" for="input02" >Sigla</label>
							<div class="col-sm-5"><input type="text" name="descrip2" class="form-control" id="input02" placeholder="Sigla" required/></div>
						</div>
						<div class="form-group">
							<label  class="col-sm-2 control-label" for="input03">Estado</label>
							<div class="col-sm-10">
								<div class="radio">
									<label><input type="radio" name="opcion1" value="1" checked /> Activo</label>
									<label><input type="radio" name="opcion1" value="0" /> Inactivo</label>
								</div>
							</div>
						</div>		
				</div>
				
				<!-- Modal Footer -->
				<div class="modal-footer">
					<button type="reset" onclick="location.reload();" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
					<button type="submit" name="agregar" class="btn btn-primary">Guardar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<!-- /#MODAL MODIFICACIONES -->
	<div class="modal fade" id="modalmod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header"><button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h3 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-pencil"></i> Modificar Registro</h3>
				</div>
            
				<!-- Modal Body -->
				<div class="modal-body">
					<form class="form-horizontal" name="modificarform" action="" onsubmit="return submitForm();" method="post" role="form">
						<div class="form-group">
							<input type="numeric" name="codigo1" class="hide" id="input0" />
							<label  class="col-sm-2 control-label" for="input1">Descripción</label>
							<div class="col-sm-10"><input type="text" name="descrip1" class="form-control" id="input1" placeholder="Descripción" required /></div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label" for="input2" >Sigla</label>
							<div class="col-sm-5"><input type="text" name="descrip2" class="form-control" id="input2" placeholder="Sigla" required/></div>
						</div>
						<div class="form-group">
							<label  class="col-sm-2 control-label" for="input3">Estado</label>
							<div class="col-sm-10">
								<div class="radio">
									<label><input type="radio" name="opcion1" value="1" checked /> Activo</label>
									<label><input type="radio" name="opcion1" value="0" /> Inactivo</label>
								</div>
							</div>
						</div>		
				</div>
				
				<!-- Modal Footer -->
				<div class="modal-footer">
					<button type="reset" onclick="location.reload();" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
					<button type="submit" name="modificar" class="btn btn-primary">Guardar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<!-- /#MODAL ELIMINACIONES -->
	<div class="modal fade" id="modalbor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header"><button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h3 class="modal-title" id="myModalLabel"><i class="glyphicon glyphicon-trash"></i> Borrar Registro</h3>
				</div>
            
				<!-- Modal Body -->
				<div class="modal-body">
					<form class="form-horizontal" name="borrarform" action="" onsubmit="return submitForm();" method="post" role="form">
						<div class="form-group">
							<input type="numeric" name="codigo1" class="hide" id="input00" />
							<div class="alert alert-danger alert-dismissable col-sm-10 col-sm-offset-1">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								¡¡¡ATENCION!!! ...Se borrara el siguiente registro:.
							</div>
						</div>
				</div>
				
				<!-- Modal Footer -->
				<div class="modal-footer">
					<button type="" onclick="location.reload();" class="btn btn-warning" data-dismiss="modal">Cancelar</button>
					<button type="submit" name="borrar" class="btn btn-danger">Borrar</button>
					</form>
				</div>
			</div>
		</div>
	</div>
    
</html>