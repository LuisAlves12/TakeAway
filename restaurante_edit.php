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
            $stm->bind_param("i",$idFilme);
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
    <title>Editar filme</title>
</head>
<body style="color:white;background-color:black">
    <h1 style="text-align:center;">Editar restaurante</h1>
    <form action="restaurante_update.php?restaurante=<?php echo $restaurante['id_restaurante']; ?>" method="post">
        
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
    else{
        echo "Precisa estar logado.<br>";
        echo "A ser redirecionado para a pagina de login";
        header("refresh:5; url=login.php");
    }
}
?>
<br><br>
<a href="index.php" style="color:white">Pagina Inicial</a>