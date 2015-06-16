<?php 
session_start();
?>
<?php
/*
 * Autor: Marcos A. Riveros.
 * Año: 2015
 * Sistema de ONM CONTROL INTN
 */
 include '../funciones.php';
conexionlocal();
$mail= $_REQUEST['mail'];
$ci=$_REQUEST['ci'];
//$pwd= md5($pwd); esto usaremos despues para comparar carga que se realizara en md5
//session_start();
//print_r($_REQUEST);
//////////////////////////INGRESO DE USUARIO
	$sql= "SELECT * FROM clientes cli
        WHERE cli.cli_mail = '$mail' AND cli.cli_ruc=('$ci') and cli.estado='t'" ;
	//echo "$sql";
	//echo $n.' ---'.$sql; 
	$datosusr = pg_query($sql);
        $row = pg_fetch_array($datosusr);
        $n=0;
        $n = count($row['cli_nom']);
	if($n==0)
	{
		echo '<script type="text/javascript">
                         alert("Datos erroneos ingresados..!");
			 window.location="http://localhost/app/ONM/web/login_clientes/acceso.html";
                      </script>';
	}
	else
	{
            $_SESSION["nombre_usuario"] = $row['cli_nom'];
            $_SESSION["codigo_usuario"] = $row['cli_cod'];
            
            header("Location:http://localhost/app/ONM/web/area_clientes/menu_clientes.php");
	} 
	exit;
?>