<?php 
session_start();
?>
<?php
/*
 * Autor: Marcos A. Riveros.
 * Año: 2015
 * Sistema de Precintos INTN
 */
 include '../web/funciones.php';
 conexionlocal();
$usr= $_REQUEST['username'];
$pwd=$_REQUEST['clave'];
//$pwd= md5($pwd); esto usaremos despues para comparar carga que se realizara en md5
//session_start();
//print_r($_REQUEST);
//////////////////////////INGRESO DE USUARIO
	$sql= "SELECT * FROM usuarios u
        WHERE u.usu_username = '$usr' AND u.usu_pass =('$pwd') and u.estado='t'" ;
	//echo "$sql";
	//echo $n.' ---'.$sql; 
	$datosusr = pg_query($sql);
        $row = pg_fetch_array($datosusr);
        $n=0;
        $n = count($row['usu_nom']);
	if($n==0)
	{
		echo '<script type="text/javascript">
                         alert("Nombre de Usuario o Password no valido..!");
			 window.location="http://localhost/app/ONMWORK-CONTROL/login/acceso.html";
                      </script>';
	}
	else
	{
            $_SESSION["nombre_usuario"] = $row['usu_nom'];
            $_SESSION["codigo_usuario"] = $row['usu_cod'];
            $_SESSION["categoria_usuario"] = $row['usu_cat'];
            
            header("Location:http://localhost/app/ONMWORK-CONTROL/web/menu.php");
	} 
	exit;
?>