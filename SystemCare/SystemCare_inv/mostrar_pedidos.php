<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Pedidos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body id="fondo">
<?php 
    session_start();
    // Comprobamos si el usuario ha iniciado sesión
    if (!isset($_SESSION['usuario'])) {
        // Si el usuario no ha iniciado sesión, lo redirigimos a la página de inicio de sesión
        header("Location: login.php");
        exit;
    }
    // Verificar si el carro existe en la variable de sesión
    if (!isset($_SESSION['carro'])) {
        // Si el carro no existe, crear un array vacío para almacenar los productos
        $_SESSION['carro'] = array();
    }
?>
<?php include_once('header.php');?>

<?php
    // Definir las credenciales de conexión
    $servername = "localhost";
    $username = "systemadmin";
    $password = "abc123.";
    $dbname = "SystemCare_inv";
    // Definir la variable $usuario
    $usuario = $_SESSION['usuario'];
    // Crear la conexión
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Verificar si la conexión es exitosa
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }
    
    // Construir la consulta SQL para obtener los productos del pedido
    $sql = "SELECT pedidos.idPedido, pedidos.usuario, linea_pedido.idProducto, productos.categoria, productos.caracteristicas, productos.distribuidor, productos.precio, linea_pedido.unidades 
        FROM pedidos 
        INNER JOIN linea_pedido ON pedidos.idPedido = linea_pedido.idPedido 
        INNER JOIN productos ON linea_pedido.idProducto = productos.id 
        WHERE pedidos.usuario = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $usuario);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    // Mostrar los productos en una tabla
    echo '<br>';
    echo '<table id="categorias">';
    echo '<tr><th>IdPedido</th><th>Usuario</th><th>Categoría</th><th>Características</th><th>Distribuidor</th><th>Precio</th><th>Unidades</th><th>Total</th></tr>';
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $total = $fila['precio'] * $fila['unidades'];
            echo '<tr>';
            echo '<td>' . $fila['idPedido'] . '</td>';
            echo '<td>' . $fila['usuario'] . '</td>';
            echo '<td>' . $fila['categoria'] . '</td>';
            echo '<td>' . $fila['caracteristicas'] . '</td>';
            echo '<td>' . $fila['distribuidor'] . '</td>';
            echo '<td>' . $fila['precio'] . '€</td>';
            echo '<td>' . $fila['unidades'] . '</td>';
            echo '<td>' . $total . '€</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="8"><h1>No se han realizado pedidos</h1></td></tr>';
    }
    echo '</table>';


    // Liberar memoria y cerrar conexión
    mysqli_free_result($resultado);
    mysqli_close($conn);
?>

</body>
</html>



