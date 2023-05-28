<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['id']) && isset($_POST['categoria']) && isset($_POST['caracteristicas']) && isset($_POST['distribuidor']) && isset($_POST['precio'])) {
    // Obtener los datos del producto desde el formulario
    $id = $_POST['id'];
    $categoria = $_POST['categoria'];
    $caracteristicas = $_POST['caracteristicas'];
    $distribuidor = $_POST['distribuidor'];
    $precio = $_POST['precio'];

    // Agregar los datos del producto al array del carro en la variable de sesión
    $producto = array('id' => $id, 'categoria' => $categoria, 'caracteristicas' => $caracteristicas, 'distribuidor' => $distribuidor, 'precio' => $precio);
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
