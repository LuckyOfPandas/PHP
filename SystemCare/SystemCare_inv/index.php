<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Tienda Hardware</title>
	<link rel="stylesheet" href="css/style.css">
</head>

<body id ="fondo">


<form action="login.php" method="post">
  <div class="imgcontainer">
    <img src="img/img_avatar2.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label for="usuario"><b>Usuario</b></label>
    <input type="text" placeholder="Enter User" name="usuario" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <button type="submit">Login</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn">Cancel</button>
  </div>
</form>
</body>