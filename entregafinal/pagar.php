<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['carro'])) {
    header("Location: mostrar_carro.php");
    exit;
}

// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Insertar el pedido en la tabla "pedidos"
$email = $_SESSION['email'];
$total = 0;
foreach ($_SESSION['carro'] as $producto) {
    $total += $producto['precio'];
}

$sql = "INSERT INTO pedidos (usuario) VALUES (?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
if (!mysqli_stmt_execute($stmt)) {
    die('Error al insertar el pedido: ' . mysqli_error($conn));
}
$id_pedido = mysqli_insert_id($conn);

// Insertar cada producto en la tabla "linea_pedido"
foreach ($_SESSION['carro'] as $producto) {
    $id_producto = (int) $producto['id'];
    $sql = "INSERT INTO linea_pedido (idPedido, idProducto) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id_pedido, $id_producto);
    if (!mysqli_stmt_execute($stmt)) {
        die('Error al insertar el producto en la línea de pedido: ' . mysqli_error($conn));
    }
}

// Borrar el contenido del array "carro"
$_SESSION['carro'] = array();

// Redirigir al usuario de vuelta a la página anterior
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    // Si no hay una página anterior, redirigir al usuario a la página principal
    header("Location: mostrar_carro.php");
}
exit;
?>
