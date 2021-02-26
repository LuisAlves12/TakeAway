<?php
include "css.php";
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body style="color:white;background-color:black">
<h1 style="text-align:center;">Register</h1>
<form method="post" action="processa_register.php">
<label>Nome</label><input type="text" name="nome" required><br>
<label>User_Name</label><input type="text" name="user_name" required><br>
<label>email</label><input type="text" name="email" required><br>
<label>Palavra-passe</label><input type="text" name="password" required><br>
<input type="submit" name="login"><br>
</body>
</html>