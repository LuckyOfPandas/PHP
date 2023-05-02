<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['id']) && isset($_POST['categoria']) && isset($_POST['color']) && isset($_POST['marca']) && isset($_POST['precio'])) {
    // Obtener los datos del producto desde el formulario
    $id = $_POST['id'];
    $categoria = $_POST['categoria'];
    $color = $_POST['color'];
    $marca = $_POST['marca'];
    $precio = $_POST['precio'];

    // Agregar los datos del producto al array del carro en la variable de sesión
    $producto = array('id' => $id, 'categoria' => $categoria, 'color' => $color, 'marca' => $marca, 'precio' => $precio);
    $_SESSION['carro'][] = $producto;
}

// Redirigir al usuario de vuelta a la página anterior
if(isset($_SERVER['HTTP_REFERER'])) {
    header("Location: ".$_SERVER['HTTP_REFERER']);
} else {
    // Si no hay una página anterior, redirigir al usuario a la página principal
    header("Location: login.php");
}
exit;
?>
