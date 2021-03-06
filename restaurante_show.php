<?php
include "css.php";
    session_start();
    if(!isset($_SESSION['login'])){
        $_SESSION['login']="incorreto";
    }
    if($_SESSION['login']== "correto" && isset($_SESSION['login'])){
        if($_SERVER['REQUEST_METHOD']=="GET"){
            if(!isset($_GET['restaurante']) || !is_numeric($_GET['restaurante'])){
                echo '<script>alert("Erro ao abrir  o restaurante");</script>';
                echo 'Aguarde um momento. A reencaminhar página';
                header("refresh:5;url=index.php");
                exit();
            }
            $idRestaurante=$_GET['restaurante'];
            $con = new mysqli("localhost","root","","takeaway");
    
            if($con->connect_errno!=0){
                echo 'Occoreu um erro no acesso à base de dados. <br>'.$con->connect_error;
                exit();
            }
            else{
                $sql = 'select * from takeaway where id_restaurante = ?';
                $stm = $con->prepare($sql);
                if($stm!=false){
                    $stm->bind_param('i',$idRestaurante);
                    $stm->execute();
                    $res=$stm->get_result();
                    $restaurante = $res->fetch_assoc();
                    $stm->close();
                }
                else{
                    echo '<br>';
                    echo ($con->error);
                    echo '<br>';
                    echo "Aguarde um momento.A reencaminhar página";
                    echo '<br>';
                    header("refresh:5; url=index.php");
                }
            }
        }
        ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Detalhes do Restaurante</title>
</head>
<body style="color:white;background-color:black">
<nav class="navbar navbar-expand-lg navbar bg-dark">
    <div class="navbar-nav">
        <a class="nav-item nav-link" href="index.php" style="color:white">Pagina Inicial</a>
        <a class="nav-item nav-link" href="restaurante_index.php" style="color:white">Restaurante</a>
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
<h1 style="text-align:center;">Detalhes do Restaurante</h1>
<?php
    if(isset($restaurante)){
        echo '<br>';
        echo "Restaurante: ".$restaurante['restaurante'];
        echo '<br>';
        echo "Morada: ".$restaurante['morada'];
        echo '<br>';
        echo "Localização: ".$restaurante['localizacao'];
        echo '<br>';
    }
    else{
        echo '<h2>Parece que o restaurante selecionado não existe. <br>Confirme a sua seleção.</h2>';
    }
    echo '<br>';
    echo '<a href="restaurante_edit.php?restaurante='.$restaurante['id_restaurante'].'" style="color:white">Editar restaurante</a>';
    echo ' '; 
    echo '<a href="restaurante_delete.php?restaurante='.$restaurante['id_restaurante'].'" style="color:white">Eliminar restaurante</a>';
?>
</body>
</html>
