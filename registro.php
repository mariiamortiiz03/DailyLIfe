<?php 

include 'db_conn.php';

session_start();

//Control de acceso:
if (isset($_SESSION['id'])) {
    header('Location: home.php');
}

$error =  false;
$errores['email'] = ' ';
$errores['pw'] = ' ';
$errores['nombre'] = ' ';
$errores['repeatPW'] = ' ';

if(isset($_POST['registrar'])) {

    if(empty($_POST['email'])) {
        $errores['email'] = "Se requiere un email.";
        $error = true;
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = "Formato incorrecto. Debe introducir email ejemplo@ejemplo.com";
        $error = true;
    } else {
        $email = $_POST['email'];
    }

    if(empty($_POST['pw'])) {
        $errores['pw'] = "Se requiere una contraseña.";
        $error = true;
    } else {
        $pw = $_POST['pw'];
    }

    if(empty($_POST['repeatPW'])) {
        $errores['repeatPW'] = "Repita la contraseña.";
        $error = true;
    } else {
        $repeatPW = $_POST['repeatPW'];
    }

    if(empty($_POST['nombre'])) {
        $errores['nombre'] = "Se requiere una nombre de usuario.";
        $error = true;
    } else {
        $nombre = $_POST['nombre'];
    }

    if (!$error) {
        if($pw != $repeatPW) {
            $errores['pw'] = "Las contraseñas no coinciden.";
            $error = true;
        } else {
            $consulta = $conn->query("SELECT id,pw FROM usuarios WHERE correo='$email' ");
            if(($row = $consulta->fetch(PDO::FETCH_OBJ)) !=null) {
                $errores['email'] = "El usuario ya esta registrado.";
            } else {
                $pw = password_hash($pw, PASSWORD_DEFAULT);
                $consulta = $conn->exec("INSERT INTO usuarios(pw, correo, nombre) VALUES ('$pw', '$email', '$nombre')");
                $consultaID = $conn->query("SELECT id,nombre FROM usuarios WHERE correo='$email'");
                $row = $consultaID->fetch(PDO::FETCH_OBJ);
                $_SESSION['id'] = $row->id;
                $_SESSION['nombre'] = $row->nombre;
                header("Location:home.php");
            }
        }
    }


}


?>

<!doctype html>
<html lang="en">

<head>
    <!-- Etiquetas <meta> obligatorias para Bootstrap -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Enlazando el CSS de Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel=StyleSheet href="css/style.css">

</head>



<body>
    <!-- Barra de navegacion-->
    <nav class="navbar navbar-expand-lg navbar-light bg-primary fixed-top">
        <a class="navbar-brand" href="#">Daily.Life</a>
        <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"></button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="login.php">Acceder </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registro.php">Registrarse</a>
                </li>

            </ul>

        </div>
    </nav>


    <!-- Formulario-->

    <br>



    <div class="row">
        <div class="form-holder">
            <div class="form-content">
                <div class="form-items">
                    <h3>Ingrese sus datos</h3>
                  
                    <form method="POST" action="" >

                        <div class="col-md-12">
                            <input class="form-control" type="text" name="nombre" placeholder="Nombre">
                            <div class="valid-feedback">Username field is valid!</div>
                            <div class="invalid-feedback">Username field cannot be blank!</div>
                            <span style="color:red"><?=$errores['nombre']?></span>
                        </div>
                        

                        <div class="col-md-12">
                            <input class="form-control" type="email" name="email" placeholder="E-mail ">
                            <div class="valid-feedback">Email field is valid!</div>
                            <div class="invalid-feedback">Email field cannot be blank!</div>
                            <span style="color:red"><?=$errores['email']?></span>
                            
                        </div>
                        

                        <div class="col-md-12">
                            <input class="form-control" type="password" name="pw" placeholder="Nueva Contraseña">
                            <div class="valid-feedback">Password field is valid!</div>
                            <div class="invalid-feedback">Password field cannot be blank!</div>
                            <span style="color:red"><?=$errores['pw']?></span>
                        </div>

                        <div class="col-md-12">
                            <input class="form-control" type="password" name="repeatPW" placeholder="Repite la Contraseña">
                            <div class="valid-feedback">Password field is valid!</div>
                            <div class="invalid-feedback">Password field cannot be blank!</div>
                            <span style="color:red"><?=$errores['repeatPW']?></span>
                        </div>


                        <!-- <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                            <label class="form-check-label">I confirm that all data are correct</label>
                            <div class="invalid-feedback">Please confirm that the entered data are all correct!</div>
                        </div> -->


                        <div class="form-button mt-3">
                            <button id="submit" type="submit" name="registrar" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>




</body>