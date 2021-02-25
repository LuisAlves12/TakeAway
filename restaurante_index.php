<?php
include "css.php";
    session_start();
    $con = new mysqli("localhost","root","","takeaway");
    if($con->connect_errno!=0){
        echo "Ocorreu um erro no acesso à base de dados ".$con->connect_error;
        exit;
    }
    else{
?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="ISO-8859-1">
        <title>Take Away</title>
    </head>
    <body style="color:white;background-color:black">
        <h1 style="text-align:center;">Take Away</h1>
    <?php
        $stm = $con->prepare('select * from takeaway');
        $stm->execute();
        $res=$stm->get_result();
        while($resultado = $res->fetch_assoc()){
            echo '<a href="restaurante_show.php?restaurante='.$resultado['id_restaurante'].'" style="color:white">';
            echo $resultado['restaurante'];
            echo '</a>';
            echo '<br>';
        }
        $stm->close();
        
        ?>
         <br> <br>
        
    </body>
</html>

<?php
    }
?>