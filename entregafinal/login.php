<?php
// Definir las credenciales de conexión
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tienda";

session_start();

// Crear la conexión
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar si la conexión es exitosa
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}



// Obtener el email y la contraseña del formulario
$email = $_POST['email'];
$password = $_POST['psw'];

// HAGO ESTO PARA QUE AL ENTRAR EN UNA PÁGINA QUE NO SEA EL LOGIN SIN SESIÓN INICIADA LUEGO TE REDIRIGA AL LOGIN DIRECTAMENTE
// Ahora que sabemos que los credenciales son correctos, guardamos el correo electrónico en una variable de sesión
$_SESSION['email'] = $email;

// Construir la consulta SQL
$sql = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$password'";

// Ejecutar la consulta SQL
$resultado = mysqli_query($conn, $sql);

// Verificar si se encontró un registro con las credenciales proporcionadas
if (mysqli_num_rows($resultado) == 1) {
    // Inicio de sesión exitoso, redirigir a bienvenida.php
    header("Location: bienvenida.php");
} else {
    // Credenciales incorrectas, volver al formulario de inicio de sesión
    header("Location: index.php");
}

// Cerrar la conexión
mysqli_close($conn);



?>