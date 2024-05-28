<?php
session_start();
function inserirDoador($conexao, $nomedoador, $enderecodoador, $teldoador,$fotodoador){

    $query ="INSERT INTO tb_doador(nome_doador, endereco_doador, tel_doador,foto_doador)values('{$nomedoador}','{$enderecodoador}','{$teldoador}','{$fotodoador}')";

    return mysqli_query($conexao, $query);
}

function loginDoador($conexao, $teldoador){
    $query = "SELECT * FROM tb_doador where tel_doador= '{$teldoador}'";
    $result = mysqli_query($conexao, $query)or die (mysqli_error($conexao)); 

    if(mysqli_num_rows($result) > 0){

        $rows = mysqli_fetch_assoc($result);

        return $rows;
    }else{
        return false;
    }
}

function minhasDoacoes($conexao){
    $codigodoador = $_SESSION['codigo_doador'];
    $query="SELECT doa.*, t.* from tb_doacao as doa left join tb_transporte as t on doa.cod_transporte = t.cod_transporte where doa.cod_doador = '{$codigodoador}'";
    $result =  mysqli_query($conexao, $query)or die (mysqli_error($conexao));

    if(mysqli_num_rows($result)>0){
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row; 
        }
        return $rows;

    }else{
        return false;
    }
}





