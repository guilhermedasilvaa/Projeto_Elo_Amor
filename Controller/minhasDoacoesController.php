<?php
include_once("../Model/conexao.php");
include_once("../Model/bancoDoador.php");

extract($_REQUEST, EXTR_OVERWRITE);

$cadastradas = minhasDoacoes($conexao);
if($cadastradas){
    $_SESSION['minhas'] = [];
    foreach($cadastradas as $registro):
        $data_doacao = new DateTime($registro['data_doacao']);
        $data_doacao_formatada = $data_doacao -> format('d/m/Y H:i');
        $_SESSION['minhas'][] = [
            'codigo_doacao_minha'=> $registro['cod_doacao'],
            'telefone_transporte_minha'=> $registro['tel_transporte'],
            'item_doacao_minha'=> $registro['item_doacao'],
            'quantidade_doacao_minha'=> $registro['quantidade_doacao'],
            'nome_transporte_minha' => $registro['nome_transporte'],
            'veiculo_transporte_minha' => $registro['veiculo_transporte'],
            'placa_transporte_minha' => $registro['placa_transporte'],
            'data_doacao_minha'=> $data_doacao_formatada
        ];
    endforeach;
}else{
    return null;
}