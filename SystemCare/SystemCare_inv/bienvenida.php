
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tienda</title>
	<link rel="stylesheet" href="css/style.css">
</head>
<body id="fondo">
<h1 style="top: 10px; right: 10px; color: white; font-size: 24px;text-align: center;">
	<?php
session_start();
// Comprobamos si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Si el usuario no ha iniciado sesión, lo redirigimos a la página de inicio de sesión
    header("Location: login.php");
    exit;
}

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
$sql = "SELECT identidad FROM usuarios WHERE usuario = ?";

// Preparar la consulta
$stmt = mysqli_prepare($conn, $sql);

// Verificar si ocurrió un error al preparar la consulta
if (!$stmt) {
    die("Error en la consulta preparada: " . mysqli_error($conn));
}

// Obtener el usuario de la sesión
$usuario = $_SESSION['usuario'];

// Vincular el parámetro al marcador de posición
mysqli_stmt_bind_param($stmt, "s", $usuario);

// Ejecutar la consulta preparada
mysqli_stmt_execute($stmt);

// Obtener el resultado de la consulta
$resultado = mysqli_stmt_get_result($stmt);

// Obtener el valor de la columna "identidad"
if ($fila = mysqli_fetch_assoc($resultado)) {
    $identidad = $fila['identidad'];
    // Mostrar el valor de la columna "identidad"
    echo "Ha iniciado sesión como: " . $identidad;
}

// Liberar memoria y cerrar conexión
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
</h1>
	<?php include_once('header.php');?>	
</body>
</html>