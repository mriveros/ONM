<?php
session_start();
if(!isset($_SESSION['codigo_usuario']))
header("Location:http://localhost/app/ONM/login/acceso.html");
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

    <title>ONM- Tecnicos</title>
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
		function modificar(codcliente){
			$('tr').click(function() {
			indi = $(this).index();
                        //var codusuario=document.getElementById("dataTables-example").rows[indi+1].cells[0].innerText;
			var nombre=document.getElementById("dataTables-example").rows[indi+1].cells[1].innerText;
			var apellido=document.getElementById("dataTables-example").rows[indi+1].cells[2].innerText;
                        var ci=document.getElementById("dataTables-example").rows[indi+1].cells[3].innerText;
			var mail=document.getElementById("dataTables-example").rows[indi+1].cells[4].innerText;
                        var nro=document.getElementById("dataTables-example").rows[indi+1].cells[5].innerText;
                        //var estado=document.getElementById("dataTables-example").rows[indi+1].cells[5].innerText;
                        document.getElementById("txtCodigo").value = codcliente;
                        document.getElementById("txtNombre").value = nombre;
			document.getElementById("txtApellido").value = apellido;
			document.getElementById("txtCi").value = ci;
                        document.getElementById("txtMail").value = mail;
                       
			});
		};
		function eliminar(codcliente){
			document.getElementById("txtCodigoE").value = codcliente;
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
                      <h1 class="page-header">Tecnicos - <small>ONM WORKFLOW</small></h1>
                </div>	
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Listado de Tecnicos
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr class="success">
                                            <th>Codigo</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>CI</th>
                                            <th>E-mail</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                    <?php
                    $query = "select * from tecnicos;";
                    $result = pg_query($query) or die ("Error al realizar la consulta");
                    while($row1 = pg_fetch_array($result))
                    {
                        $estado=$row1["estado"];
                        if($estado=='t'){$estado='Activo';}else{$estado='Inactivo';}
                        echo "<tr><td>".$row1["tec_cod"]."</td>";
                        echo "<td>".$row1["tec_nom"]."</td>";
                        echo "<td>".$row1["tec_ape"]."</td>";
                        echo "<td>".$row1["tec_ci"]."</td>";
                        echo "<td>".$row1["tec_mail"]."</td>";
                        echo "<td>".$estado."</td>";
                        echo "<td>";?>
                        
                        <a onclick='modificar(<?php echo $row1["tec_cod"];?>)' class="btn btn-success btn-xs active" data-toggle="modal" data-target="#modalmod" role="button">Modificar</a>
                        <a onclick='eliminar(<?php echo $row1["tec_cod"];?>)' class="btn btn-danger btn-xs active" data-toggle="modal" data-target="#modalbor" role="button">Borrar</a>
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
                    <a  class="btn btn-primary" data-toggle="modal" data-target="#modalagr" role="button">Nuevo</a>
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
                                    <form  autocomplete="off" class="form-horizontal" name="agregarform" action="../class/ClsTecnicos.php" method="post" role="form">
						
                                        <div class="form-group">
                                            <label  class="col-sm-2 control-label" for="input01">Nombre</label>
                                            <div class="col-sm-10">
                                            <input type="text" name="txtNombreA" class="form-control" id="txtNombreA" placeholder="ingrese nombre" required />
                                            </div>
					</div>
					<div class="form-group">
                                            <label  class="col-sm-2 control-label" for="input01">Apellido</label>
                                            <div class="col-sm-10">
                                            <input type="text" name="txtApellidoA" class="form-control" id="txtApellidoA" placeholder="ingrese apellido" required />
                                            </div>
					</div>
                                        <div class="form-group">
                                            <label  class="col-sm-2 control-label" for="input01">CI</label>
                                            <div class="col-sm-10">
                                            <input type="text" name="txtCiA" class="form-control" id="txtCiA" placeholder="ingrese CI" required />
                                            </div>
					</div>
                                        <div class="form-group">
                                            <label  class="col-sm-2 control-label" for="input01">E-Mail</label>
                                            <div class="col-sm-10">
                                            <input type="mail" name="txtMailA" class="form-control" id="txtMailA" placeholder="ingrese e-mail" required />
                                            </div>
					</div>
					<div class="form-group">
                                            <label  class="col-sm-2 control-label" for="input03">Estado</label>
                                            <div class="col-sm-10">
                                            <div class="radio">
                                            <label><input type="radio" name="opcionA" value="1" checked /> Activo</label>
                                            <label><input type="radio" name="opcionA" value="0" /> Inactivo</label>
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
                                    <form  autocomplete="off" class="form-horizontal" name="modificarform" action="../class/ClsTecnicos.php"  method="post" role="form">
                                        <div class="form-group">
                                            <div class="col-sm-10">
                                            <input type="hidden" name="txtCodigo" class="form-control" id="txtCodigo"  />
                                            </div>
					</div>
                                        <div class="form-group">
                                            <input type="numeric" name="codigo1" class="hide" id="input000" />
                                            <label  class="col-sm-2 control-label" for="input01">Nombre</label>
                                            <div class="col-sm-10">
                                            <input type="text" name="txtNombre" class="form-control" id="txtNombre"  required />
                                            </div>
					</div>
					<div class="form-group">
                                            <label  class="col-sm-2 control-label" for="input01">Apellido</label>
                                            <div class="col-sm-10">
                                            <input type="text" name="txtApellido" class="form-control" id="txtApellido" placeholder="ingrese apellido" required />
                                            </div>
					</div>
                                        <div class="form-group">
                                            <label  class="col-sm-2 control-label" for="input01">Ruc</label>
                                            <div class="col-sm-10">
                                            <input type="text" name="txtCi" class="form-control" id="txtCi" placeholder="ingrese nombre de usuario" required />
                                            </div>
					</div>
                                        <div class="form-group">
                                            <label  class="col-sm-2 control-label" for="input01">E-mail</label>
                                            <div class="col-sm-10">
                                            <input type="mail" name="txtMail" class="form-control" id="txtMail" placeholder="ingrese una contraseña" required />
                                            </div>
					</div>
                                        <div class="form-group">
                                            <label  class="col-sm-2 control-label" for="input03">Estado</label>
                                            <div class="col-sm-10">
                                            <div class="radio">
                                            <label><input type="radio" name="txtOpcion" value="1" checked /> Activo</label>
                                            <label><input type="radio" name="txtOpcion" value="0" /> Inactivo</label>
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
                                    <form class="form-horizontal" name="borrarform" action="../class/ClsTecnicos.php" onsubmit="return submitForm();" method="post" role="form">
						<div class="form-group">
							<input type="numeric" name="txtCodigoE" class="hide" id="txtCodigoE" />
							<div class="alert alert-danger alert-dismissable col-sm-10 col-sm-offset-1">
								<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
								¡¡¡ATENCION!!! ...Se borrara el siguiente registro..
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