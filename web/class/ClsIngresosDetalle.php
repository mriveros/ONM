<?php
/*
 * Autor: Marcos A. Riveros.
 * Año: 2015
 * Sistema de Control ONM-INTN
 */

    include '../funciones.php';
    conexionlocal();
    
    //Datos del Form Agregar
    if  (empty($_POST['txtCantidadA'])){$cantidadA=0;}else{ $cantidadA = $_POST['txtCantidadA'];}
    if  (empty($_POST['txtInstrumentoA'])){$instrumentoA=0;}else{ $instrumentoA= $_POST['txtInstrumentoA'];}
    
    //Datos del Form Modificar
    if  (empty($_POST['txtCodigo'])){$codigoModif=0;}else{$codigoModif=$_POST['txtCodigo'];}
    if  (empty($_POST['txtCantidad'])){$cantidadM=0;}else{ $cantidadM = $_POST['txtCantidad'];}
    if  (empty($_POST['txtInstrumento'])){$instrumentoM=0;}else{ $instrumentoM= $_POST['txtInstrumento'];}
   
    
    //recupera el codigo anterior de la cabecera
    $resultado=pg_query("Select max(ing_cod)as ing_cod from ingreso;");
    $row= pg_fetch_row($resultado) ; 
    $codcabecera=$row[0];
    //DAtos para el Eliminado Logico
    if  (empty($_POST['txtCodigoE'])){$codigoElim=0;}else{$codigoElim=$_POST['txtCodigoE'];}
        //Si es agregar
        if(isset($_POST['agregar'])){           
                //se define el Query   
                $query = "INSERT INTO ingreso_detalle(ing_cod,ing_cant,ins_cod,estado,situacion) "
                        . "VALUES ($codcabecera,$cantidadA,$instrumentoA,'t','RECEPCION');";
                //ejecucion del query
                $ejecucion = pg_query($query)or die('Error al realizar la carga');
                $query = '';
                header("Refresh:0; url=http://localhost/app/ONM/web/ingresos/IngDetalle.php");
                }
        //si es Modificar    
        if(isset($_POST['modificar'])){
            
            pg_query("update ingreso_detalle set ing_cant='$cantidadM',ins_cod=$instrumentoM "
                    . "WHERE ins_cod=$codigoModif");
            $query = '';
           header("Refresh:0; url=http://localhost/app/ONM/web/ingresos/IngDetalle.php");
        }
        //Si es Eliminar
        if(isset($_POST['borrar'])){
            pg_query("delete ingreso_detalle  WHERE ing_coddet=$codigoElim");
           header("Refresh:0; url=http://localhost/app/ONM/web/ingresos/IngDetalle.php");
	}
