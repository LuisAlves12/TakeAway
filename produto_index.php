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
        <a class="nav-item nav-link" href="index.php" style="color:white">Pagina Inicial</a>
        <a class="nav-item nav-link" href="produto_index.php" style="color:white">Produto</a>
        <a class="nav-item nav-link" href="" style="color:white"></a>
        <a class="nav-item nav-link" href="login.php" style="color:white">Login</a>
        <a class="nav-item nav-link" href="register.php" style="color:white">Register</a>  
        <?php
            if($_SESSION['login']== "correto" && isset($_SESSION['login'])){
        ?>
            <a class="nav-item nav-link" href="processa_logout.php" style="color:white">Logout</a>
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
        <h1 style="text-align:center;">Produto</h1>
    <?php
        $stm = $con->prepare('select * from produto');
        $stm->execute();
        $res=$stm->get_result();
        while($resultado = $res->fetch_assoc()){
            echo '<a href="produto_show.php?produto='.$resultado['id_produto'].'" style="color:white">';
            echo $resultado['produto'];
            echo '</a>';
            echo '<br>';
        }
        $stm->close();
        
        ?>
        <br>
         <a href="produto_create.php" style="color:white">Adicionar Produto</a>
    </body>
    
</html>