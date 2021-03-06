<?php
include "css.php";
session_start();
    if(!isset($_SESSION['login'])){
        $_SESSION['login']="incorreto";
    }
    if($_SESSION['login']== "correto" && isset($_SESSION['login'])){
if($_SERVER['REQUEST_METHOD']=="GET"){

    if(isset($_GET['restaurante']) && is_numeric($_GET['restaurante'])){
        $idRestaurante = $_GET['restaurante'];
        $con = new mysqli("localhost","root","","takeaway");

        if($con->connect_errno!=0){
            echo "<h1>Ocorreu um erro no acesso à base de dados.<br>".$con->connect_error."</h1>";
            exit();
        }
        $sql = "Select * from takeaway where id_restaurante=?";
        $stm = $con->prepare($sql);

        if($stm!=false){
            $stm->bind_param("i",$idRestaurante);
            $stm->execute();
            $res=$stm->get_result();
            $restaurante = $res->fetch_assoc();
            $stm->close();
        }
    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="ISO-8859-1">
    <title>Editar Restaurante</title>
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
    <h1 style="text-align:center;">Editar restaurante</h1>
    <form action="restaurante_update.php?restaurante=<?php echo $restaurante['id_restaurante']; ?>" method="post">
        <label>Nome Restaurante</label><input type="text" name="restaurante" required value="<?php echo $restaurante['restaurante'];?>"><br>
        <label>Morada</label><input type="text" name="morada" required value="<?php echo $restaurante['morada'];?>"><br>
        <label>Localização</label><input type="text" name="localizacao" required value="<?php echo $restaurante['localizacao'];?>"><br>
        <input type="submit" name="enviar"><br>
    </form>
</body>
<?php
 }
 else{
     echo ("<h1>Houve um erro ao processar o seu pedido.<br>Dentro de segundos será reencaminhado!</h1>");
     header("refresh:5; url=restaurante_show.php");
 }
 }

?>