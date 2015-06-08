<?php
/*
 * Autor: Marcos A. Riveros.
 * Año: 2015
 * Sistema de Control ONM-INTN
 */

    include '../funciones.php';
    conexionlocal();
    
    //Datos del Form Agregar
    if  (empty($_POST['txtNombreA'])){$nombreA=0;}else{ $nombreA = $_POST['txtNombreA'];}
    if  (empty($_POST['txtApellidoA'])){$apellidoA=0;}else{ $apellidoA= $_POST['txtApellidoA'];}
    if  (empty($_POST['txtRucA'])){$rucA=0;}else{ $rucA= $_POST['txtRucA'];}
    if  (empty($_POST['txtMailA'])){$mailA=0;}else{ $mailA= $_POST['txtMailA'];}
    if  (empty($_POST['txtNroA'])){$nroA=0;}else{ $nroA= $_POST['txtNroA'];}
    if  (empty($_POST['txtEstadoA'])){$estadoA='f';}else{ $estadoA= 't';}
    
    //Datos del Form Modificar
    if  (empty($_POST['txtCodigo'])){$codigoModif=0;}else{$codigoModif=$_POST['txtCodigo'];}
    if  (empty($_POST['txtNombre'])){$nombreM=0;}else{ $nombreM = $_POST['txtNombre'];}
    if  (empty($_POST['txtApellido'])){$apellidoM=0;}else{ $apellidoM= $_POST['txtApellido'];}
    if  (empty($_POST['txtRuc'])){$rucM=0;}else{ $rucM= $_POST['txtRuc'];}
    if  (empty($_POST['txtMail'])){$mailM=0;}else{ $mailM= $_POST['txtMail'];}
    if  (empty($_POST['txtNro'])){$nroM=0;}else{ $nroM= $_POST['txtNro'];}
    if  (empty($_POST['txtOpcion'])){$estadoM='f';}else{ $estadoM= 't';}
    
    //DAtos para el Eliminado Logico
    if  (empty($_POST['txtCodigoE'])){$codigoElim=0;}else{$codigoElim=$_POST['txtCodigoE'];}
    
    
        //Si es agregar
        if(isset($_POST['agregar'])){
            if(func_existeDato($rucA, 'clientes', 'cli_ruc')==true){
                echo '<script type="text/javascript">
		alert("El Cliente ya existe. Intente ingresar otro Cliente");
                window.location="http://localhost/app/ONM/web/clientes/ABMcliente.php";
		</script>';
                }else{              
                //se define el Query   
                $query = "INSERT INTO clientes(cli_nom,cli_ape,cli_ruc,cli_mail,cli_nro,fecha,estado) "
                        . "VALUES ('$nombreA','$apellidoA','$rucA','$mailA','$nroA',now(),'$estadoA');";
                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                $query = '';
                header("Refresh:0; url=http://localhost/app/ONM/web/clientes/ABMcliente.php");
                }
            }
        //si es Modificar    
        if(isset($_POST['modificar'])){
            
            pg_query("update clientes set cli_nom='$nombreM',cli_ape= '$apellidoM',cli_ruc='$rucM',cli_mail='$mailM',cli_nro='$nroM',estado='$estadoM' WHERE cli_cod=$codigoModif");
            $query = '';
            header("Refresh:0; url=http://localhost/app/ONM/web/clientes/ABMcliente.php");
        }
        //Si es Eliminar
        if(isset($_POST['borrar'])){
            pg_query("update clientes set estado='f' WHERE cli_cod=$codigoElim");
            header("Refresh:0; url=http://localhost/app/ONM/web/clientes/ABMcliente.php");
	}
