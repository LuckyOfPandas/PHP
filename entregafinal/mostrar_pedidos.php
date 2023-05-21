<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar Productos</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body id="fondo">
<?php 
    session_start();
    // Comprobamos si el usuario ha iniciado sesión
    if (!isset($_SESSION['email'])) {
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
    $username = "root";
    $password = "";
    $dbname = "tienda";
    //Definir la variable  $email
    $email = $_SESSION['email'];
    // Crear la conexión
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Verificar si la conexión es exitosa
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }
    
    
    // Construir la consulta SQL
	$sql = "SELECT pedidos.idPedido, pedidos.usuario, linea_pedido.idProducto, productos.categoria, productos.color, productos.marca, productos.precio 
        FROM pedidos 
        INNER JOIN linea_pedido ON pedidos.idPedido = linea_pedido.idPedido 
        INNER JOIN productos ON linea_pedido.idProducto = productos.id 
        WHERE pedidos.usuario = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    // Mostrar los productos en una tabla
    echo '<table id="categorias">';
    echo '<tr><th>ID del Pedido</th><th>Usuario</th><th>ID del Producto</th><th>Categoría</th><th>Color</th><th>Marca</th><th>Precio</th></tr>';
    if (mysqli_num_rows($resultado) > 0) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            echo '<tr>';
            echo '<td>' . $fila['idPedido'] . '</td>';
            echo '<td>' . $fila['usuario'] . '</td>';
            echo '<td>' . $fila['idProducto'] . '</td>';
            echo '<td>' . $fila['categoria'] . '</td>';
            echo '<td>' . $fila['color'] . '</td>';
            echo '<td>' . $fila['marca'] . '</td>';
            echo '<td>' . $fila['precio'] . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="7"><h1>No se han realizado pedidos</h1></td></tr>';
    }
    echo '</table>';


    // Liberar memoria y cerrar conexión
    mysqli_free_result($resultado);
    mysqli_close($conn);

?>


</body>
</html>
