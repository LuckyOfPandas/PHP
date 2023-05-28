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
	if (!isset($_SESSION['usuario'])) {
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
			<option value="Portatil">Portátiles</option>			
			<option value="Ordenador sobremesa">Ordenadores sobremesa</option>
			<option value="Cable">Cables</option>
			<option value="Adaptador">Adaptadores</option>
			<option value="Otro">Otros</option>
		</select>
		<button type="submit">Filtrar</button>
	</form>
	</div>
	<?php
		// Definir las credenciales de conexión
		$servername = "localhost";
		$username = "systemadmin";
		$password = "abc123.";
		$dbname = "SystemCare_inv";

		// Crear la conexión
			$conn = mysqli_connect($servername, $username, $password, $dbname);

		// Verificar si la conexión es exitosa
			if (!$conn) {
				die("Conexión fallida: " . mysqli_connect_error());
			}

		// Construir la consulta preparada
			$categoria = $_GET["categoria"] ?? "";
			$sql = "SELECT id, categoria, caracteristicas, distribuidor, precio FROM productos";
			if (!empty($categoria)) {
				$sql .= " WHERE categoria=?";
			}

		// Preparar la consulta
			$stmt = mysqli_prepare($conn, $sql);

		// Verificar si ocurrió un error al preparar la consulta
			if (!$stmt) {
				die("Error en la consulta preparada: " . mysqli_error($conn));
			}

		// Vincular el parámetro al marcador de posición
			if (!empty($categoria)) {
				mysqli_stmt_bind_param($stmt, "s", $categoria);
			}

		// Ejecutar la consulta preparada
			mysqli_stmt_execute($stmt);

		// Obtener el resultado de la consulta
			$resultado = mysqli_stmt_get_result($stmt);

	// Mostrar los productos en una tabla
	echo "<table id='categorias'>";
	echo "<tr><th>Categoría</th><th>Características</th><th>Distribuidor</th><th>Precio</th><th>🛒</th></tr>";
	while ($fila = mysqli_fetch_assoc($resultado)) {
    $precio = number_format($fila["precio"], 2, ',', '') . " €"; // Agregar el símbolo del euro al final
    echo "<tr><td>" . $fila["categoria"] . "</td><td>" . $fila["caracteristicas"] . "</td><td>" . $fila["distribuidor"] . "</td><td>" . $precio . "</td><td><form action='carro.php' method='POST'><input type='hidden' name='id' value='" . $fila["id"] . "'><input type='hidden' name='categoria' value='" . $fila["categoria"] . "'><input type='hidden' name='caracteristicas' value='" . $fila["caracteristicas"] . "'><input type='hidden' name='distribuidor' value='" . $fila["distribuidor"] . "'><input type='hidden' name='precio' value='" . $fila["precio"] . "'><button type='submit'>Añadir al carro</button></form></td></tr>";
	}
	echo "</table>";



		// Liberar memoria y cerrar conexión
			mysqli_free_result($resultado);
			mysqli_close($conn);
	?>
</body>
</html>