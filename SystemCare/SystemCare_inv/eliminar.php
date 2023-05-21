<?php
session_start();

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    if (isset($_SESSION['carro'][$id])) {
        unset($_SESSION['carro'][$id]);
    }
}

header('Location: mostrar_carro.php');
exit();
?>