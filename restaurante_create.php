<?php
include "css.php";
session_start();
if(!isset($_SESSION['login'])){
    $_SESSION['login']="incorreto";
}
if($_SESSION['login']== "correto" && isset($_SESSION['login'])){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $restaurante="";
            $morada="";
            $localizacao="";
            if(isset($_POST['restaurante'])){
                $restaurante=$_POST['restaurante'];
            }
            else{
                echo '<script>alert("É obrigatório o preenchimento do nome restaurante.");</script>';
            }
            if(isset($_POST['morada'])){
                $morada=$_POST['morada'];
            }
            if(isset($_POST['localizacao'])){
                $localizacao=$_POST['localizacao'];
            }

            $con=new mysqli("localhost","root","","takeaway");
            if($con->connect_errno!=0){
                echo "Ocorreu um erro no acesso à base de dados. <br>" .$con->connect_error;
                exit;
            }
            else{
                if($con->connect_errno!=0){
                    echo "Ocorreu um erro no acesso à base de dados.<br>".$con->connect_error;
                    exit;
                }
        
                else{
                    $sql = 'insert into takeaway(restaurante,morada,localizacao) values(?,?,?)';
                    $stm = $con->prepare($sql);
                    if($stm!=false){
                        $stm->bind_param('sss',$restaurante,$morada,$localizacao);
                        $stm->execute();
                        $stm->close();
                        echo '<script>alert("Restaurante adicionado com sucesso");</script>';
                        echo 'Aguarde um momento. A reencaminhar página';
                        header("refresh:5; url=restaurante_index.php");
                    }
                    else{
                        echo($con->error);
                        echo "Aguarde um momento. A reencaminhar página";
                        header("refresh:5;url=restaurante_index.php");
                    }
                }
            }
            }
        else{
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="ISO-8859-1">
    <title>Adicionar Restaurante</title>
    </head>
    <body style="color:white;background-color:black">
    <h1 style="text-align:center;">Adicionar Realizador</h1>
    <form action="restaurante_create.php" method="post">
    <label>Restaurante</label><input type="text" name="restaurante" required><br>
    <label>Morada</label><input type="text" name="morada"><br>
    <label>Localizacao</label><input type="text" name="localizacao"><br>
    <input type="submit" name="enviar"><br>
    </form>
    </body>
    </html>
    <?php
        };
        
    }
    else{
        echo "Precisa estar logado.<br>";
        echo "A ser redirecionado para a pagina de login";
        header("refresh:5; url=login.php");
    }
?> 