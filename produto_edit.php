<?php
include "css.php";
session_start();
    if(!isset($_SESSION['login'])){
        $_SESSION['login']="incorreto";
    }
    if($_SESSION['login']== "correto" && isset($_SESSION['login'])){
if($_SERVER['REQUEST_METHOD']=="GET"){

    if(isset($_GET['produto']) && is_numeric($_GET['produto'])){
        $idProduto = $_GET['produto'];
        $con = new mysqli("localhost","root","","takeaway");
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
    
        if($con->connect_errno!=0){
            echo "<h1>Ocorreu um erro no acesso à base de dados.<br>".$con->connect_error."</h1>";
            exit();
        }
        $sql = "Select * from produto where id_produto=?";
        $stm = $con->prepare($sql);

        if($stm!=false){
            $stm->bind_param("i",$idProduto);
            $stm->execute();
            $res=$stm->get_result();
            $produto = $res->fetch_assoc();
            $stm->close();
        }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="ISO-8859-1">
    <title>Editar Produto</title>
</head>
<body style="color:white;background-color:black">
<nav class="navbar navbar-expand-lg navbar bg-dark">
    <div class="navbar-nav">
        <a class="nav-item nav-link" href="index.php" style="color:white">Pagina Inicial</a>
        <a class="nav-item nav-link" href="produto_index.php" style="color:white">produto</a>
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
    <h1 style="text-align:center;">Editar Produto</h1>
    <form enctype="multipart/form-data" action="produto_update.php?produto=<?php echo $produto['id_produto']; ?>" method="post">
        <label>Nome Produto</label><input type="text" name="produto" required value="<?php echo $produto['produto'];?>"><br>
        <label>Preço</label><input type="text" name="preco" required value="<?php echo $produto['preco'];?>"><br>
        <label>Imagem</label><input type="file" name="imagem" maxlength="50" value=""><img src="<?php echo 'imagens/'.$produto['imagem']?>" /><br>
        <input type="submit" name="enviar"><br>
    </form>
</body>
<?php
 }
 else{
     echo ("<h1>Houve um erro ao processar o seu pedido.<br>Dentro de segundos será reencaminhado!</h1>");
     header("refresh:5; url=produto_show.php");
 }
 }

?>