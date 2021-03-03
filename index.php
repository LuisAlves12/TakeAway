<?php
include "css.php";
    session_start();
    $con = new mysqli("localhost","root","","takeaway");
    if($con->connect_errno!=0){
        echo "Ocorreu um erro no acesso à base de dados ".$con->connect_error;
        exit;
    }
    else{
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="ISO-8859-1">
        <title>Take Away</title>
    </head>
    <body style="color:white;background-color:black">
    <nav class="navbar navbar-expand-lg navbar bg-dark">
    <div class="navbar-nav">
        <a class="nav-item nav-link" href="login.php" style="text-align: right;color:white">Login</a>
        <a class="nav-item nav-link" href="register.php" style="text-align: right;color:white">Register</a>  
        <?php
            if($_SESSION['login']== "correto" && isset($_SESSION['login'])){
        ?>
            <a class="nav-item nav-link" href="processa_logout.php" style="text-align: right;color:white">Logout</a>
        <?php
            }
            else{
                echo '';
            }
        }
    ?>
    </div>
    </li>
    </div>
</nav>
    <br> 
        <h1 style="text-align:center;">Take Away</h1>
        <br><br>
        <table>
		    <tr>
                <td style="color:black">----------------------------------------</td>
                <td><img src="imagem2.png" height="200" width="300"></td>
                <td><img src="imagem1.jpg" height="200" width="300"></td>
                <td><img src="imagem3.png" height="200" width="300"></td>
		    </tr>
	    </table>
        <br><br><br><br>
        <table>
		    <tr>
                <td style="color:black">-----------------------------------------------------</td>
                <td><button style='width: 200px'><a href="restaurante_index.php" style="color:black">Restaurante</a></button></td>
                <td style="color:black">-----------------------------------------</td>
                <td><button style='width: 200px'><a href="produto_index.php" style="color:black">Produto</a></button></td>
		    </tr>
	    </table>
    </body>
</html>