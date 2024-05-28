<?php

include_once("../Model/conexao.php");
include_once("../Model/bancoTransporte.php");
include_once("../Model/bancoDoacao.php");


extract($_REQUEST, EXTR_OVERWRITE);

$escolhidas = escolhidasDoacao($conexao);

if($escolhidas){
    
    $_SESSION['escolhidas'] = [];
    foreach($escolhidas as $registro):

        $data_doacao = new DateTime($registro['data_doacao']);

        $data_doacao_formatada = $data_doacao -> format('d/m/Y H:i');
        $_SESSION['escolhidas'][] = [
           
            'codigo_doacao_escolhida'=> $registro['cod_doacao'],
            'nome_doador_escolhida'=> $registro['nome_doador'],
            'telefone_doador_escolhida'=> $registro['tel_doador'],
            'item_doacao_escolhida'=> $registro['item_doacao'],
            'endereco_doacao_escolhida'=> $registro['endereco_doador'],
            'quantidade_doacao_escolhida'=> $registro['quantidade_doacao'],
            'data_doacao_escolhida'=> $data_doacao_formatada
        ];

    endforeach;
    
    
}else{
    return null;
}