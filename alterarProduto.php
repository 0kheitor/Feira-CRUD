
<?php
    include 'util.php';

    $conn = connect("pgsql:host=localhost; port=5432; dbname=feira; user=postgres; password=postgres;");
    $id = $_GET['id'];
    $varSQL = "SELECT * FROM produto WHERE id = :id";
    $select = $conn->prepare($varSQL);
    $select->bindParam(':id',$id);
    $select->execute();
    $linha = $select->fetch();

    $id = $linha['id'];
    $nome = $linha['nome'];
    $preco = $linha['preco'];
    $data = $linha['data_colheita'];
    $imageLocation = $linha['foto'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./stylesCRUD.css">
</head>
<body>
<header>
    <nav><a href="index.php" class = "nav-a"><span>Voltar</span></a></nav>
</header>
<main>
    <form action="updateProduto.php" method="post" enctype="multipart/form-data"  id = "formAdicionar">
        <fieldset>
            <input type="hidden" name = "id" id = "id" value = <?php echo $id; ?>>
            <input type="hidden" name = "oldImage" id = "oldImage" value = <?php echo $imageLocation; ?>>
            <legend>Alterar campos</legend>
            <div class = "form-unit"><label for="nome">Nome:</label><input type="text" name="nome" id = "nome"  value = "<?php echo $nome; ?>" required></div>
            <div class = "form-unit"><label for="preco">Preço:</label><input type="number" name="preco" id = "preco" step = "any" value = "<?php echo $preco; ?>" required></div>
            <div class = "form-unit"><label for="data">Data de colheita:</label><input type="date" name="data" id = "data" value = "<?php echo $data; ?>" required></div>
            <div class = "form-unit"><label for="image">Imagem: </label><input type="file" name="image" id = "image" accept="image/*"/></div>
            <div class = "form-view"><span>Imagem atual:</span><img src="<?php echo $imageLocation; ?>" alt="Imagem atual" style = "width:70px"></div>
            <div class = "form-view"><span>Preview:</span><img src="#" alt="..." id = "preview" style = "width:70px"></div>
        </fieldset>
        <button type = "submit" id = "enviar"><span>Enviar</span></button>
    </form>
</main>
<footer>
     <p>Feito por Heitor</p>
</footer>
<script src = "./script.js"></script>
<script>
    window.document.addEventListener('DOMContentLoaded', () =>{
        let theme = window.localStorage.getItem('theme') === '1';
        console.log("tema atual:" + (!theme?"light":"dark"));
        const root = window.document.querySelector('html');
        if(theme){
            root.classList.add('toggled');
        }
    });
</script>
</body> 
</html>