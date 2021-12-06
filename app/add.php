<?php

session_start();

if(isset($_POST['titulo'])) {
    require '../db_conn.php';

    $titulo = $_POST['titulo'];
    $usuario = $_SESSION['id'];

    if(empty($titulo)) {
        header("Location: ../home.php?mess=error");
    }else {
        $stmt = $conn->prepare("INSERT INTO tareas(titulo,usuario) VALUE (?,?)");
        $res = $stmt->execute([$titulo, $usuario]);

        if($res) {
            header("Location: ../home.php?mess=success");
        }else {
            header("Location: ../home.php");
        }
        $conn = null;
        exit();
    }
} else {
    header("Location: ../home.php?mess=error");
};

?>