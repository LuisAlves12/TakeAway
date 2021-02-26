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
    echo '<a href="restaurante_edit.php?filme='.$restaurante['id_restaurante'].'" style="color:white">Editar restaurante</a><br><br>';
    echo '<a href="restaurante_delete.php?filme='.$restaurante['id_restaurante'].'" style="color:white">Eliminar restaurante</a>';
?>
</body>
</html>
<?php
    }
    else{
        echo "Precisa estar logado.<br>";
        echo "A ser redirecionado para a pagina de login";
        header("refresh:5; url=login.php");
    }
?>
<br><br>
        <a href="index.php" style="color:white">Pagina Inicial</a>