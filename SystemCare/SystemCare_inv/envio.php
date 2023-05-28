<?php
session_start();

if (!isset($_SESSION['usuario'])) {
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
$dbname = "SystemCare_inv";

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Insertar el pedido en la tabla "pedidos"
$usuario = $_SESSION['usuario'];
$total = 0;
foreach ($_SESSION['carro'] as $producto) {
    $total += $producto['precio'];
}

$sql = "INSERT INTO pedidos (usuario) VALUES (?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $usuario);
if (!mysqli_stmt_execute($stmt)) {
    die('Error al insertar el pedido: ' . mysqli_error($conn));
}
$id_pedido = mysqli_insert_id($conn);

// Insertar cada producto en la tabla "linea_pedido"
foreach ($_SESSION['carro'] as $producto) {
    $id_producto = (int) $producto['id'];
    
    // Verificar si el producto ya está en la línea de pedido
    $sql = "SELECT unidades FROM linea_pedido WHERE idPedido = ? AND idProducto = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id_pedido, $id_producto);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        // El producto ya está en la línea de pedido, actualizar las unidades
        $sql = "UPDATE linea_pedido SET unidades = unidades + 1 WHERE idPedido = ? AND idProducto = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $id_pedido, $id_producto);
        if (!mysqli_stmt_execute($stmt)) {
            die('Error al actualizar las unidades del producto en la línea de pedido: ' . mysqli_error($conn));
        }
    } else {
        // El producto no está en la línea de pedido, insertarlo con unidades igual a 1
        $sql = "INSERT INTO linea_pedido (idPedido, idProducto, unidades) VALUES (?, ?, 1)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $id_pedido, $id_producto);
        if (!mysqli_stmt_execute($stmt)) {
            die('Error al insertar el producto en la línea de pedido: ' . mysqli_error($conn));
        }
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
