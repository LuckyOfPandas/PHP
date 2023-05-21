<?php
// Definir las credenciales de conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "SystemCare_inv";

session_start();

// Crear la conexión
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar si la conexión es exitosa
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

// Obtener el usuario y la contraseña del formulario
$usuario = $_POST['usuario'];
$password = $_POST['psw'];

// Encriptar la contraseña utilizando SHA-256
$hashedPassword = hash('sha256', $password);

// Ahora que sabemos que los credenciales son correctos, guardamos el correo electrónico en una variable de sesión
$_SESSION['usuario'] = $usuario;

// Construir la consulta preparada
$sql = "SELECT * FROM usuarios WHERE usuario = ? AND password = ?";
$stmt = mysqli_prepare($conn, $sql);

// Verificar si ocurrió un error al preparar la consulta
if (!$stmt) {
    die("Error en la consulta preparada: " . mysqli_error($conn));
}

// Vincular los parámetros a los marcadores de posición
mysqli_stmt_bind_param($stmt, "ss", $usuario, $hashedPassword);

// Ejecutar la consulta preparada
mysqli_stmt_execute($stmt);

// Obtener el resultado de la consulta
$resultado = mysqli_stmt_get_result($stmt);

// Verificar si se encontró un registro con las credenciales proporcionadas
if (mysqli_num_rows($resultado) == 1) {
    // Inicio de sesión exitoso, redirigir a bienvenida.php
    header("Location: bienvenida.php");
} else {
    // Credenciales incorrectas, volver al formulario de inicio de sesión
    header("Location: index.php");
}

// Cerrar la consulta preparada
mysqli_stmt_close($stmt);

// Cerrar la conexión
mysqli_close($conn);
?>


