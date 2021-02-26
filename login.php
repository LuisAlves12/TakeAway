<?php
include "css.php";
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body style="color:white;background-color:black">
<h1 style="text-align:center;">Login</h1>
<form method="post" action="processa_login.php">
<label>Nome de utilizador</label><input type="text" name="user_name" required><br>
<label>Palavra-passe</label><input type="text" name="password" required><br>
<input type="submit" name="login"><br>
</body>
</html>