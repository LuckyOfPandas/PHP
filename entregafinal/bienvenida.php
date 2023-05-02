
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
	if (isset($_SESSION['email'])) {
	$email = $_SESSION['email'];
	echo "👋 Bienvenido, $email 👋";
	} else {
		// Si el usuario no ha iniciado sesión, lo redirigimos a la página de inicio de sesión
	header("Location: login.php");
	exit;
	}?>
</h1>
	<?php include_once('header.php');?>	
</body>
</html>