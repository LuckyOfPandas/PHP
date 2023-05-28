<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carro</title>
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
if (!isset($_SESSION['carro'])) {
    $_SESSION['carro'] = array();
}

include_once('header.php');
?>


<table id='categorias'>
    <tr>
        <th>Producto</th>
        <th>Características</th>
        <th>Distribuidor</th>
        <th>Precio</th>
        <th>🛒</th>
    </tr>

    <?php
    $total = 0;
    if (empty($_SESSION['carro'])) {
        echo '<tr><td colspan="5"><h1>El carrito está vacío</h1></td></tr>';
    } else {
        foreach ($_SESSION['carro'] as $key => $producto) {
            echo '<tr>';
            echo '<td>' . $producto['categoria'] . '</td>';
            echo '<td>' . $producto['caracteristicas'] . '</td>';
            echo '<td>' . $producto['distribuidor'] . '</td>';
            echo '<td>' . number_format($producto['precio'], 2, ',', '.') . ' €</td>';
            echo '<td>';
            echo '<form method="POST" action="eliminar.php">';
            echo '<input type="hidden" name="id" value="' . $key . '">';
            echo '<button type="submit">Eliminar</button>';
            echo '</form>';
            echo '</td>';
            echo '</tr>';

            $total += $producto['precio'];
        }
        echo '<tr>';
        echo '<td>Total</td>';
        echo '<td></td>';
        echo '<td></td>';
        echo '<td>' . number_format($total, 2, ',', '.') . ' €</td>';
        echo '<td>';
        echo '<form method="POST" action="envio.php">';
        echo '<button type="submit">SOLICITAR ENVÍO</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    ?>

</table>

</body>
</html>

