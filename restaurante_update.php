<?php
include "css.php";
$idRestaurante=$_GET['restaurante'];
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $restaurante = "";
        $morada="";
        $localizacao = "";
        if(isset($_POST['restaurante'])){
            $restaurante = $_POST['restaurante'];
        }
        else{
            echo '<script>alert("É obrigatório o preenchimento o nome do restaurante.");</script>';
        }

        if(isset($_POST['morada'])){
            $morada = $_POST['morada'];
        }

        if(isset($_POST['localizacao'])){
            $localizacao = $_POST['localizacao'];
        }

        $con = new mysqli("localhost","root","","takeaway");

        if($con->connect_errno!=0){
            echo "Ocorreu um erro no acesso à base de dados.<br>".$con->connect_error;
            exit;
        }
        else{
            $sql = "update takeaway set restaurante=?,morada=?,localizacao=? where id_restaurante=?";

            $stm=$con->prepare($sql);
            if($stm!=false){
                $stm->bind_param("sssi",$restaurante,$morada,$localizacao,$idRestaurante);
                $stm->execute();
                $stm->close();
                echo '<script>alert("Restaurante alterado com sucesso!!");</script>';
                echo "Aguarde um momento. A reencaminhar página";
                header("refresh:5; url=restaurante_index.php");
            }
        }
    }
    else{
        echo "<h1> Houve um erro ao processar o seu pedido!<br>Irá ser reencaminhado!</h1>";
        header("refresh:5; url=restaurante_index.php");
    }