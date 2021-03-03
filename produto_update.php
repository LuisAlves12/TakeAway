<?php
include "css.php";
$idProduto=$_GET['produto'];
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $produto = "";
        $preco="";
        $imagem = "";
        if(isset($_POST['produto'])){
            $produto = $_POST['produto'];
        }
        else{
            echo '<script>alert("É obrigatório o preenchimento o nome do produto.");</script>';
        }

        if(isset($_POST['preco'])){
            $preco = $_POST['preco'];
        }

        $imagem="";
	    $novo_nome="";
        if(isset($_FILES['imagem'])){
            date_default_timezone_set('Europe/London'); //timezone local para adicional ao nome da imagem
            $ext=strtolower(substr($_FILES['imagem']['name'], -4)); //extensão da imagem
            $novo_nome=date("Y.m.d-H.i.s").$ext; //atribuir novo nome à imagem
            $dir='imagens/';
            move_uploaded_file($_FILES['imagem']['tmp_name'], $dir.$novo_nome); //upload do ficheiro
        }
		$imagem=$novo_nome;
    
        $con = new mysqli("localhost","root","","takeaway");

        if($con->connect_errno!=0){
            echo "Ocorreu um erro no acesso à base de dados.<br>".$con->connect_error;
            exit;
        }
        else{
            $sql = "update produto set produto=?,preco=?,imagem=? where id_produto=?";

            $stm=$con->prepare($sql);
            if($stm!=false){
                $stm->bind_param("sssi",$produto,$preco,$imagem,$idProduto);
                $stm->execute();
                $stm->close();
                echo '<script>alert("Produto alterado com sucesso!!");</script>';
                echo "Aguarde um momento. A reencaminhar página";
                header("refresh:5; url=produto_index.php");
            }
        }
    }
    else{
        echo "<h1> Houve um erro ao processar o seu pedido!<br>Irá ser reencaminhado!</h1>";
        header("refresh:5; url=produto_index.php");
    }