<?php
session_start();
function inserirTransporte($conexao, $nometransporte, $veiculotransporte, $teltransporte, $placatransporte, $fototransporte){

    $query ="INSERT INTO tb_transporte(nome_transporte, veiculo_transporte, tel_transporte, placa_transporte, foto_transporte)values('{$nometransporte}','{$veiculotransporte}','{$teltransporte}','{$placatransporte}','{$fototransporte}')";

    return mysqli_query($conexao, $query);
}

function loginTransporte($conexao, $teltransporte){
    $query = "SELECT * FROM tb_transporte where tel_transporte= '{$teltransporte}'";
    $result = mysqli_query($conexao, $query)or die (mysqli_error($conexao)); 

    if(mysqli_num_rows($result) > 0){

        $rows = mysqli_fetch_assoc($result);

        return $rows;
    }else{
        return false;
    }
}

function escolherDoacao($conexao){
    $data_atual =date('Y-m-d');
    $query = "SELECT d.nome_doador, d.tel_doador, d.endereco_doador, t.nome_transporte, doa.* 
    FROM tb_doacao as doa 
    JOIN tb_doador as d 
    ON doa.cod_doador = d.cod_doador 
    LEFT JOIN tb_transporte as t 
    ON doa.cod_transporte = t.cod_transporte 
    WHERE doa.cod_transporte IS NULL
    and doa.data_doacao >= CURRENT_DATE";
   
    $result = mysqli_query($conexao, $query)or die (mysqli_error($conexao));

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

function escolhidasDoacao($conexao){
    $codigotransporte = $_SESSION['codigo_transporte'];
    $query = "SELECT d.nome_doador, d.tel_doador, d.endereco_doador, doa.* FROM tb_doacao as doa JOIN tb_doador as d ON doa.cod_doador = d.cod_doador JOIN tb_transporte as t ON doa.cod_transporte = t.cod_transporte WHERE doa.cod_transporte = '{$codigotransporte}'";
    $result = mysqli_query($conexao, $query)or die (mysqli_error($conexao));

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

function cancelarEntrega($conexao, $codigodoacao){
    $query = "UPDATE tb_doacao set cod_transporte = null where cod_doacao = '{$codigodoacao}'";
    return mysqli_query($conexao, $query);  
}


