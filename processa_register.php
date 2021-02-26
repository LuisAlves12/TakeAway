<?php
include "css.php";
    session_start();
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $nome = $_POST['nome'];
        $utilizador = $_POST['user_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password_encrip=password_hash($password, PASSWORD_DEFAULT);
        $con = new mysqli("localhost","root","","takeaway");

        if($con->connect_errno!=0){
            echo "Ocorreu um erro no acesso à base de dados.<br>".$con->connect_error;
            exit;
        }
        else{
            $sql = "insert into utilizadores(nome,user_name,email,password) values(?,?,?,?)";
            $stm = $con->prepare($sql);
            if($stm!=false){
                $stm->bind_param("ssss",$nome,$utilizador,$email,$password_encrip);
                $stm->execute();
                $stm->close();
                echo '<script>alert("Utilizador adicionado com sucesso");</script>';
                echo 'Aguarde um momento. A reencaminhar página';
                header("refresh:5; url=index.php");
            }
            else{
                echo($con->error);
                echo "Aguarde um momento. A reencaminhar página";
                header("refresh:5;url=index.php");
            }
        }
    }