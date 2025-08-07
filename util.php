<?php

    function connect($stringConn){
        try{
            $tempConn = new PDO($stringConn);
        }
        catch(PDOException $e){
            echo "Error: ".$e->getMessage();
        }
        return $tempConn;
    }

    function crudTable($queryConn, $alterPhp = "", 
                       $delPhp = "", $tableName = " ", $idEntity="id",){//Imprime a tabela de forma formatada
        
        echo "<table class = 'sfnc-table'>"; 
        echo "<caption>$tableName</caption>";
        echo "<thead><tr>";
        $schemaArray = [];
        $arrayBooleans = []; //Verifica os booleanos, pois quando valores boolean vão para o php fica em forma de TINYINT(1)
        $arrayBoolCont = 0;
        for($i = 0; $i < $queryConn->columnCount(); $i++){// imrpime as colunas th
            $schemaArray[] = $queryConn->getColumnMeta($i);
            if((strtolower($schemaArray[$i]["native_type"]) == 'bool')){//armazena o indice das colunas com boolean
                $arrayBooleans[$arrayBoolCont] = $i;
                $arrayBoolCont++;
            }
                
        }
        $cont = 1;
        foreach($schemaArray as $a){
            echo "<th>".$a["name"]."</th>";
            $cont++;
        }
        echo "<th> </th>";
        echo "</tr></thead><tbody>";
        while($line = $queryConn->fetch(PDO::FETCH_ASSOC)){ //imprime as linhas
            echo "<tr>";
            $cont = 0;
            foreach($line as $cell){//imprime celula por celula de cada linha
                if(in_array($cont, $arrayBooleans)){//verifica se a coluna é boolean, caso sim, ira formatar
                    $tempBoolean = ($cell == 1) ? '&#x2713;' : 'X';
                    echo "<td>$tempBoolean</td>";
                    $cont++;
                    continue;
                }
                //CÓDIGO ESPECÍFICO
                if($schemaArray[$cont]['name'] == 'foto'){//aqui ele vai printar um <td> especifico quando perceber que essa coluna é de imagens/fotos
                    echo "<td class = 'td-image'><img src = '.$cell' alt = 'imagem nao encontrada' style = 'height:110px'></td>";
                    $cont++;
                    continue;
                }
                if($schemaArray[$cont]['name'] == 'data_colheita'){//aqui ele vai printar um <td> especifico quando perceber que essa coluna é de data
                    echo "<td>" . htmlspecialchars(date('d/m/Y', strtotime($line['data_colheita']))) . "</td>";//transforma a data em uma forma mais visivel
                    $cont++;
                    continue;
                }

                //printa os valores em si (que nao atendem as condições acima)
                echo "<td>".$cell."</td>";
                $cont++;
            }
            echo "<td><a href='$alterPhp?id=".$line[$idEntity]."'>Alterar</a>"."&nbsp;".
                "<a href='$delPhp?id=".$line[$idEntity]."'>Excluir</a></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    }

    //Customização especifica do crud ou de tabelas .sfnc-table (nome da classe)
    function styleSheet(//Função apenas para estilização e pre-declaração de atributos para window (que serão utilizados)
        $tableId = ".sfnc-table", $styleString_Table_Background = "#255255255", $styleString_Table_Header = "#2b75ffff",
        $styleString_textColor = "rgba(26, 26, 26, 1)",  $styleString_tagAColor = "#ffffffff", 
        $styleEvenRow = "#ffffffff", $styleOddRow = "#f1f1f1ff", $body_background = "rgba(232, 251, 255, 1)", 
        $trHover = "#4444", $table_collapse = "collapse", $table_line_border_colors = "grey solid 1px", $dark = false
    ){
        if($dark){
            $table_collapse = "separate";
            $table_line_border_colors = "none";
            $tableId = ".sfnc-table";
            $styleString_Table_Background = "#1E1E1E";        
            $styleString_Table_Header = "#007B9E";       
            $styleString_textColor = "#E0E0E0";        
            $styleString_tagAColor = "#E0E0E0";
            $styleEvenRow = "rgba(255, 255, 255, 0.05)";
            $body_background = "#151515";
            $styleOddRow = "rgba(240,240,240, 0.02)";
            $trHover = "rgba(102, 111, 226, 0.1)";
        }

        
        echo "<style>
        body{
            user-select: none; /* you can remove this */
            background-color: $body_background;
        }

        $tableId caption{
            background-color: $styleString_Table_Header;
            font-size: 2rem;
            color: $styleString_tagAColor;
            border-radius: 10px 10px 0px 0px;
        }

        $tableId{
            box-sizing: border-box !important;
            border-collapse: $table_collapse;
            user-select: none;
            border: white; 
            padding: 5px; 
            width: 100%;
            box-shadow: 2px 0px 8px 4px rgba(33,33,33, 0.3);
            background-color: $styleString_Table_Background;
            font-family: 'Segoe UI', 'arial';
            color: $styleString_textColor;
        }

        $tableId tbody tr:nth-child(even){
            background-color: $styleEvenRow;
            border: $table_line_border_colors;
        }

         $tableId tbody tr:nth-child(odd){
            background-color: $styleOddRow;
            border: $table_line_border_colors;
        }

        $tableId tbody tr:hover{
            background-color: $trHover;
        }

        $tableId th{
            height: 50px;
            background-color: $styleString_Table_Header;
            color:  $styleString_tagAColor;
        }

        $tableId tr td {
            padding: 10px;
            text-align: center;
        }   

        $tableId a, $tableId a:active{
            all:unset;
            color: $styleString_tagAColor;
            user-select: none;
            cursor: pointer;
            font-family: 'arial', 'sans-serif';
            background-color:  $styleString_Table_Header;
            padding: 10px;
            border-radius: 4px;
            transition: 0.5s;
        }

        $tableId a:hover{
            scale: 1.1;
            background-color:  rgba(98, 153, 255, 1);
            color: white
        }

        @media (max-width: 768px) {
        $tableId, $tableId *:not(a):not(thead):not(.td-image img){
            display: block;
        }

        $tableId thead {
            display: none; /* Esconde os cabeçalhos */
        }

        $tableId tr {
            margin-bottom: 1rem;
            border: 1px solid #444;
            padding: 10px;
            background: #1e1e1e;
        }

        }
        </style>
        <script>window.tableCrud = '$tableId';</script>
        <script>window.localStorage.setItem('theme','$dark');</script>
        ";
    }
?>