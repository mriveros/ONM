<?php 
if(!isset($_SESSION)) 
    { session_start();}
include ("../bd/conectar.php");

function verificar_login($user,$password,&$result) {
	$sql= "SELECT u.usu_cod,u.usu_nick,f.fun_nom,f.fun_ape,u.usu_cat,a.ain_des,u.usu_est
				FROM usuario u,funcionario f,area_informatica a
				WHERE f.fun_cod=u.fun_cod AND a.ain_cod=u.ain_cod AND a.ain_cod=1 AND u.usu_nick = '$user' and u.usu_pas = md5('$password')";
	//$sql = "SELECT * FROM usuario WHERE usu_nick = '$user' and usu_pas = md5('$password')";
    $rec = mysql_query($sql);
    $count = 0;
    while($row = mysql_fetch_object($rec)){
        $count++;
        $result = $row;
    }
    if($count == 1){
        return 1;
    }else{
        return 0;
    }
} 
if(!isset($_SESSION['userid']))
{
    if(isset($_POST['login']))
    {
        if(verificar_login($_POST['user'],$_POST['password'],$result) == 1)
        {
            $_SESSION['userid'] = $result->usu_cod;
			$_SESSION['usercate'] = $result->usu_cat;
			$_SESSION['usernom'] = $result->fun_nom;
			$_SESSION['userape'] = $result->fun_ape;
			$_SESSION['usernick'] = $result->usu_nick;
			//$_SESSION['userdep'] = $result->dep_cod;
            header("location:principal.php");
        }else{ 
			//echo '<h2>Su usuario o contrase&ntilde;a es incorrecto, intente nuevamente.</h2>';
			echo "<script type=\"text/javascript\">alert(\"... Su USUARIO o CONTRASEÑA son INCORRECTOS... Intentelo Nuevamente ... \");</script>";
        } 
    } 
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Sistema de Actividades</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Acceso al Sistema</h3>
                    </div>
                    <div class="panel-body">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 login-box">
								<form name="logueo" action="" onsubmit="return submitForm();" method="post">
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
										<input name="user" type="text" class="form-control" placeholder="Usuario" required autofocus />
									</div><br>
									<div class="input-group">
										<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
										<input name="password" type="password" class="form-control" placeholder="Contrase&ntilde;a" required />
									</div>
									<br>No estas Registrado? <a href="registro.php">Registrate</a>
							</div>
						</div>
					</div>
					<div class="panel-footer">
						<div class="row">
							<div class="col-xs-12 col-sm-8 col-md-8 col-sm-offset-5 col-md-offset-5">
								<button type="submit" name="login" class="btn btn-labeled btn-success">
									<span class="btn-label"><i class="glyphicon glyphicon-ok"></i></span>Aceptar</button>
								<button type="reset" class="btn btn-labeled btn-danger">
									<span class="btn-label"><i class="glyphicon glyphicon-remove"></i></span>Cancelar</button>
								</form>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>
</html>
<?php 
}
?>