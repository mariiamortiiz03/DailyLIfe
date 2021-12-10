<?php
/*verifica que se haya logado, si es asi lo manda al index a registrar actividad*/
include 'db_conn.php';



$error =  false;
$errores['email'] = ' ';
$errores['pw'] = ' ';

if (isset($_POST['login'])) {

    session_start();

    if (empty($_POST['email'])) {
        $errores['email'] = "Se requiere un email.";
        $error = true;
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errores['email'] = "Formato incorrecto. Debe introducir email ejemplo@ejemplo.com";
        $error = true;
    } else {
        $email = $_POST['email'];
    }

    if (empty($_POST['pw'])) {
        $errores['pw'] = "Se requiere una contraseña.";
        $error = true;
    } else {
        $pw = $_POST['pw'];
    }

    if (!$error) {

        $consulta = $conn->query("SELECT id,pw,nombre FROM usuarios WHERE correo='$email' ");
        if (($row = $consulta->fetch(PDO::FETCH_OBJ)) != null) {
            if (password_verify($pw, $row->pw)) {
                $_SESSION['id'] = $row->id;
                $_SESSION['nombre'] = $row->nombre;
                header("Location:home.php");
            } else {
                $errores['pw'] = "La contraseña es incorrecta.";
            }
        } else {
            $errores['email'] = "El usuario no existe.";
        }
    }

    var_dump($_POST['email']);

    //header("Location:index.php");
}

?>




<!doctype html>
<html lang="es">

<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel=StyleSheet href="css/style.css">>
</head>


<body>

    <!-- Logo-->
    <!-- Logo-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <a class="navbar-brand" href="index.php">
            <img src="img/logoPequenio.png">
            <span class="display-6"> Daily.life</span>
        </a>
        <!-- Logo y barra de navegacion-->

        <button class="navbar-toggler hidden-lg-up" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"></button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Inicio </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="registro.php">Registrarse</a>

                </li>

            </ul>

        </div>
    </nav>




    <br>
    <br>

    <!------------------------Formulario------------------------------------>

    <div class="container">
        <div class="row">
            <!--desplazamos 4 columnas a las izquierda-->
            <div class="col-md-4">

            </div>
            <!--medidas de las columnas (la mayor es de 12)-->
            <div class="col-md-4">



                <!--Cuerpo del Login nuevo-->

                <div class="row">
                    <div class="form-holder">
                        <div class="form-content">
                            <div class="form-items">
                                <h3 class="centrarLogin">Acceder</h3>
                                <br>



                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label>Correo Electronico</label>
                                        <input type="email" class="form-control" name="email" placeholder="introduza su correo">
                                        <span style="color:red"><?= $errores['email'] ?></span>

                                    </div>
                                    <div class="form-group">
                                        <label>Contraseña</label>
                                        <input type="password" class="form-control" name="pw" placeholder="Introduza su clave">
                                        <span style="color:red"><?= $errores['pw'] ?></span>
                                    </div>
                                    <div class="form-check">


                                    </div>
                                    <div class="centrar">

                                        <button type="submit" name="login" class="btn btn-primary">Login</button>

                                        <a class="btn btn-primary" href="registro.php" role="button">Registro</a>


                                    </div>

                                </form>



                            </div>
                            </form>
                        </div>
                    </div>
                </div>



            </div>






        </div>

    </div>
    </div>



</body>

</html>