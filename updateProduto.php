<?php

    include 'util.php';
    $conn = connect("pgsql:host=localhost; port=5432; dbname=feira; user=postgres; password=postgres;");
    $varSQL = "UPDATE produto SET
                nome = :nome, preco = :preco, data_colheita = :data_colheita, foto = :foto where id = :id";

    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $data = $_POST['data'];
    $newImage = $_FILES['image'];

    $oldImageLocation = $_POST['oldImage'];

    $aleatory = bin2hex(random_bytes(16));
    $imageLocation = "/images/" . $aleatory . $newImage["name"];

    $changeImage = false;
    if(file_exists($newImage["tmp_name"])){
        $changeImage = true;
    }
    
    $imageOpyion = ($changeImage)?   $imageLocation : $oldImageLocation;


    if ($changeImage  && filesize($newImage["tmp_name"]) <= 0 ){
        exit('Uploaded file has no contents.');
    }
    
    $update = $conn->prepare($varSQL);
    $update->bindParam(':id', $id);
    $update->bindParam(':nome', $nome);
    $update->bindParam(':preco', $preco);
    $update->bindParam(':foto',  $imageOpyion);
    $update->bindParam(':data_colheita', $data);

    try{
        $update->execute();
        if( $changeImage){
            unlink(__DIR__.$oldImageLocation);
            move_uploaded_file( $newImage["tmp_name"], __DIR__ . $imageLocation );
        }
        header('location: index.php');
    }
    catch(PDOException){
        echo "UM ERRO ACONTECEU! OPERAÇÃO MAL REALIZADA!";
    }
?>