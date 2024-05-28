<?php

include_once("../Model/conexao.php");
include_once("../Model/bancoTransporte.php");
include_once("../Model/bancoDoacao.php");

extract($_REQUEST, EXTR_OVERWRITE);

$escolher = escolherDoacao($conexao);


if($escolher){ 
    $_SESSION['doacoes'] = [];
    foreach($escolher as $registro):
     // Data e hora atuais
        $data_doacao = new DateTime($registro['data_doacao']);

        $data_doacao_formatada = $data_doacao -> format('d/m/Y H:i');
        $_SESSION['doacoes'][] = [
            'nome_transporte' => $registro['nome_transporte'],
            'codigo_doacao'=> $registro['cod_doacao'],
            'nome_doador'=> $registro['nome_doador'],
            'telefone_doador'=> $registro['tel_doador'],
            'item_doacao'=> $registro['item_doacao'],
            'endereco_doacao'=> $registro['endereco_doador'],
            'quantidade_doacao'=> $registro['quantidade_doacao'],
            'data_doacao'=> $data_doacao_formatada
            ];

    endforeach;   
}else{
    return null;
}
