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
}?>
	<?php include_once('header.php');?>	
	<div id="filtro">
	<form method="GET">
		<select id="categoria" name="categoria">
			<option value="">Sin filtro</option>
			<option value="pantalon">Pantalones</option>
			<option value="camiseta">Camisetas</option>
			<option value="sudadera">Sudaderas</option>
		</select>
		<button type="submit">Filtrar</button>
	</form>
	</div>
	<?php
		// Definir las credenciales de conexión
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "tienda";


		// Crear la conexión
			$conn = mysqli_connect($servername, $username, $password, $dbname);

		// Verificar si la conexión es exitosa
			if (!$conn) {
				die("Conexión fallida: " . mysqli_connect_error());
			}

		// Construir la consulta SQL
			$categoria = $_GET["categoria"] ?? "";
			$sql = "SELECT id, categoria, color, marca, precio FROM productos";
			if (!empty($categoria)) {
				$sql .= " WHERE categoria='$categoria'";
			}

		// Ejecutar la consulta SQL
			$resultado = mysqli_query($conn, $sql);

		// Mostrar los productos en una tabla
    echo "<table id='categorias'>";
    echo "<tr><th>Categoría</th><th>Color</th><th>Marca</th><th>Precio</th><th>🛒</th></tr>";
    while ($fila = mysqli_fetch_assoc($resultado)) {
      echo "<tr><td>" . $fila["categoria"] . "</td><td>" . $fila["color"] . "</td><td>" . $fila["marca"] . "</td><td>" . $fila["precio"] . "</td><td><form action='carro.php' method='POST'><input type='hidden' name='id' value='" . $fila["id"] . "'><input type='hidden' name='categoria' value='" . $fila["categoria"] . "'><input type='hidden' name='color' value='" . $fila["color"] . "'><input type='hidden' name='marca' value='" . $fila["marca"] . "'><input type='hidden' name='precio' value='" . $fila["precio"] . "'><button type='submit'>Añadir al carro</button></form></td></tr>";
    }
    echo "</table>";


		// Liberar memoria y cerrar conexión
			mysqli_free_result($resultado);
			mysqli_close($conn);
	?>
</body>
</html>