<?php
include "css.php";
    session_start();
    if(!isset($_SESSION['login'])){
        $_SESSION['login']="incorreto";
    }
    if($_SESSION['login']== "correto" && isset($_SESSION['login'])){
        if($_SERVER['REQUEST_METHOD']=="GET"){
            if(!isset($_GET['produto']) || !is_numeric($_GET['produto'])){
                echo '<script>alert("Erro ao abrir  o produto");</script>';
                echo 'Aguarde um momento. A reencaminhar página';
                header("refresh:5;url=produto_index.php");
                exit();
            }
            $idProduto=$_GET['produto'];
            $con = new mysqli("localhost","root","","takeaway");
    
            if($con->connect_errno!=0){
                echo 'Occoreu um erro no acesso à base de dados. <br>'.$con->connect_error;
                exit();
            }
            else{
                $sql = 'select * from produto where id_produto = ?';
                $stm = $con->prepare($sql);
                if($stm!=false){
                    $stm->bind_param('i',$idProduto);
                    $stm->execute();
                    $res=$stm->get_result();
                    $produto = $res->fetch_assoc();
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
<title>Detalhes do Produto</title>
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
<h1 style="text-align:center;">Detalhes do Produto</h1>
<?php
    if(isset($produto)){
        echo '<br>';
        echo "Produto: ".$produto['produto'];
        echo '<br>';
        echo "Preço: ".$produto['preco'];
        echo '<br>';
        echo '<img src="imagens/'.$produto['imagem'].'" />';
        echo '<br>';
    }
    else{
        echo '<h2>Parece que o produto selecionado não existe. <br>Confirme a sua seleção.</h2>';
    }
    echo '<br>';
    echo '<a href="produto_edit.php?produto='.$produto['id_produto'].'" style="color:white">Editar Produto</a>';
    echo ' '; 
    echo '<a href="produto_delete.php?produto='.$produto['id_produto'].'" style="color:white">Eliminar Produto</a>';
?>
</body>
</html>