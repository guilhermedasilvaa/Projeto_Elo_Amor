<?php
session_start();

include_once("../Model/bancoTransporte.php");
include_once("../Model/conexao.php");

extract($_REQUEST, EXTR_OVERWRITE);
if(inserirTransporte($conexao, $nometransporte, $veiculotransporte, $teltransporte, $placatransporte, $fototransporte)){
    $transporte = loginTransporte($conexao,$teltransporte);
    if($transporte){
        $_SESSION['codigo_transporte'] = $transporte['cod_transporte'];
        $_SESSION['nome_transporte'] = $transporte['nome_transporte'];
        
    }
    echo'<script type="text/javascript"> alert("Cadastrado!"); window.location.href="../View/index.php?escolher_doacao=true";</script>';
    
}else{
    
    echo'<script type="text/javascript"> alert("verifique se colocou todos os dados corretamente, e tente novamente!");</script>';
    
}
?>
