<?php
session_start();
include_once("bancoTransporte.php");
include_once("bancoDoador.php");

function inserirDoacao($conexao, $itemdoacao, $quantidadedoacao, $datadoacao){
    $codigodoador = $_SESSION['codigo_doador'];
    $query = "INSERT INTO tb_doacao(item_doacao, quantidade_doacao, data_doacao, cod_doador)values('{$itemdoacao}','{$quantidadedoacao}','{$datadoacao}','{$codigodoador}')";

    return mysqli_query($conexao, $query); 
}

function doacaoEscolhida($conexao, $codigodoacao){
    $codigotransporte = $_SESSION['codigo_transporte'];
    $query = "UPDATE tb_doacao set cod_transporte = '{$codigotransporte}' where cod_doacao = '{$codigodoacao}'";
    return mysqli_query($conexao, $query);  
}






