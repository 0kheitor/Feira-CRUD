<?php
    include 'util.php';

    $varConn = "pgsql:host=localhost; port=5432; dbname=feira; user=postgres; password=postgres;";
    $conn = connect($varConn);
    $queryConn = $conn->query("SELECT * FROM produto ORDER BY id");
?>
<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles1.css">
    <script src="https://kit.fontawesome.com/4ec170f2bb.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <h1>SISTEMA CRUD - FEIRA</h1>
    </header>
    <main>
        <a href="adicionarProduto.html" id = "tag-adicionar"><div id = "adicionar"><span>Adicionar</span><i class="fa-solid fa-file-lines"></i></div></a>
        <?php
        crudTable($queryConn, "alterarProduto.php","excluirProduto.php", tableName: "Produtos");
        styleSheet(dark: true);
        ?>
    </main>
    <script>
        const valueFlag = 3; //MUDA POR AQUI

        window.document.addEventListener('DOMContentLoaded', () => {

            if(!window.tableCrud){
                console.log('ERRO, não existe window.tableCrud');
                return;
            }

            const table = document.getElementsByClassName(window.tableCrud)[0]
            const rowsValue = document.querySelectorAll(`${window.tableCrud} tbody tr td:nth-child(${valueFlag})`);

            rowsValue.forEach((el) =>{
                el.innerText = Number.parseFloat(el.innerText).toLocaleString('pt-BR',{style: 'currency', currency:'BRL'});
            });

        });
    </script>
</body>
</html>
