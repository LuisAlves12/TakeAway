<?php
include "css.php";
session_start();
if(!isset($_SESSION['login'])){
    $_SESSION['login']="incorreto";
}
if($_SESSION['login']== "correto" && isset($_SESSION['login'])){
        if($_SERVER['REQUEST_METHOD']=="POST"){
            $produto="";
            $preco="";
            $imagem="";
            if(isset($_POST['produto'])){
                $produto=$_POST['produto'];
            }
            else{
                echo '<script>alert("É obrigatório o preenchimento o nome do produto.");</script>';
            }
            if(isset($_POST['preco'])){
                $preco=$_POST['preco'];
            }
            if(isset($_POST['imagem'])){
                $imagem=$_POST['imagem'];
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
                    $sql = 'insert into produto(produto,preco,imagem) values(?,?,?)';
                    
                    $stm = $con->prepare($sql);
                    if($stm!=false){
                        $stm->bind_param('sss',$produto,$preco,$imagem);
                        $stm->execute();
                        $stm->close();
                        echo '<script>alert("Produto adicionado com sucesso");</script>';
                        echo 'Aguarde um momento. A reencaminhar página';
                        header("refresh:5; url=produto_index.php");
                    }
                    else{
                        echo($con->error);
                        echo "Aguarde um momento. A reencaminhar página";
                        header("refresh:5;url=produto_index.php");
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
    <title>Adicionar Produto</title>
    </head>
    <body style="color:white;background-color:black">
    <h1 style="text-align:center;">Adicionar Produto</h1>
    <form action="produto_create.php" method="post" enctype="multipart/form-data">
    <label>Produto</label><input type="text" name="produto" required><br>
    <label>Restaurante</label><input type="text" name="id_restaurante" required><br>
    <label>Preço</label><input type="text" name="preco"><br>
    <label>Imagem</label><input type="file" name="imagem" maxlength="50" value="<?php echo $produto['imagem'];?>"><br>
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
    