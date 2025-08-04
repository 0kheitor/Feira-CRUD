<?php
    include 'util.php';

    $image_file = $_FILES["image"];
    $nome = $_POST['nome'];
    $preco = $_POST['preco'];
    $data = $_POST['data'];
    $aleatory = bin2hex(random_bytes(16));

    $imageLocation = "/images/" . $aleatory . $image_file["name"];
    
    if (!isset($image_file)) {
        exit('No file uploaded.');
    }

    if (filesize($image_file["tmp_name"]) <= 0) {
        exit('Uploaded file has no contents.');
    }

    $varQuery = "INSERT INTO produto(nome, preco, data_colheita, foto) VALUES(:nome,:preco,:data,:foto)";
    $varConn = "pgsql:host=localhost; port=5432; dbname=feira; user=postgres; password=postgres;";
    $conn = connect($varConn);
    $insert = $conn->prepare($varQuery);
    $insert ->bindParam(':nome',$nome);
    $insert ->bindParam(':preco',$preco);
    $insert ->bindParam(':data',$data);
    $insert ->bindParam(':foto',$imageLocation);




    try {
        $insert->execute();

        move_uploaded_file( $image_file["tmp_name"], __DIR__ . $imageLocation );
        header("location: index.php");
    } 
    catch (PDOException $e) {
        echo "NÃO FOI POSSIVEL REALIZAR A OPERAÇÃO!<br>";
        echo "ERRO: " . $e->getMessage();
    }
?>