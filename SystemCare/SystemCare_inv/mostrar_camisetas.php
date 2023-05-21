<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mostrar camisetas</title>
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
    $username = "root";
    $password = "";
    $dbname = "SystemCare_inv";

    // Crear la conexión
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Verificar si la conexión es exitosa
    if (!$conn) {
        die("Conexión fallida: " . mysqli_connect_error());
    }

    // Construir la consulta preparada
    $sql = "SELECT id, categoria, color, marca, precio FROM productos WHERE categoria=?";

    // Preparar la consulta
    $stmt = mysqli_prepare($conn, $sql);

    // Verificar si ocurrió un error al preparar la consulta
    if (!$stmt) {
        die("Error en la consulta preparada: " . mysqli_error($conn));
    }

    // Vincular el parámetro al marcador de posición
    $categoria = 'camiseta';
    mysqli_stmt_bind_param($stmt, "s", $categoria);

    // Ejecutar la consulta preparada
    mysqli_stmt_execute($stmt);

    // Obtener el resultado de la consulta
    $resultado = mysqli_stmt_get_result($stmt);

	// Mostrar los productos en una tabla
	echo "<table id='categorias'>";
	echo "<tr><th>Categoría</th><th>Color</th><th>Marca</th><th>Precio</th><th>🛒</th></tr>";
	while ($fila = mysqli_fetch_assoc($resultado)) {
    $precio = number_format($fila["precio"], 2, ',', '') . " €"; // Agregar el símbolo del euro al final
    echo "<tr><td>" . $fila["categoria"] . "</td><td>" . $fila["color"] . "</td><td>" . $fila["marca"] . "</td><td>" . $precio . "</td><td><form action='carro.php' method='POST'><input type='hidden' name='id' value='" . $fila["id"] . "'><input type='hidden' name='categoria' value='" . $fila["categoria"] . "'><input type='hidden' name='color' value='" . $fila["color"] . "'><input type='hidden' name='marca' value='" . $fila["marca"] . "'><input type='hidden' name='precio' value='" . $fila["precio"] . "'><button type='submit'>Añadir al carro</button></form></td></tr>";
	}
	echo "</table>";

    // Liberar memoria y cerrar conexión
    mysqli_free_result($resultado);
    mysqli_close($conn);
?>
</body>
</html>