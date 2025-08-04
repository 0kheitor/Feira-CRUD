<?php
    include 'util.php';

    $conn = connect("pgsql:host=localhost; port=5432; dbname=feira; user=postgres; password=postgres;");
    $id = $_GET['id'];
    $varSQL = "SELECT foto FROM produto WHERE id = :id";//por meio dessa query eu consigo recuperar o endereço da imagem
    $queryConn = $conn->prepare($varSQL);
    $queryConn->bindParam(':id',$id);

    try{
        $queryConn -> execute();
        $line = $queryConn->fetch();
        $imageLocation = $line['foto'];
        unlink(__DIR__ . $imageLocation);
        header('location: index.php');
    }
    catch(PDOException $e){// Exibe a mensagem de erro e não sai da pagina (recurso de depuração)
        echo "NÃO FOI POSSIVEL REALIZAR A OPERAÇÃO!<br>";
        echo "ERRO: ".$e->getMessage();
    }



    $varSQL = "DELETE FROM produto WHERE id=:id";
    $delete = $conn->prepare($varSQL);
    $delete ->bindParam(':id',$id);



    try{
        $delete ->execute();
        header('location: index.php');
    }
    catch(PDOException $e){// Exibe a mensagem de erro e não sai da pagina (recurso de depuração)
        echo "NÃO FOI POSSIVEL REALIZAR A OPERAÇÃO!<br>";
        echo "ERRO: ".$e->getMessage();
    }
?>