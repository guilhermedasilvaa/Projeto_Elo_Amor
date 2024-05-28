<?php
session_start();
include_once("../Model/conexao.php");
include_once("../Model/bancoTransporte.php");
extract($_REQUEST, EXTR_OVERWRITE);
$transporte = loginTransporte($conexao, $teltransporte);
$_SESSION['nome_transporte'] = $transporte['nome_transporte'];
$_SESSION['codigo_transporte'] = $transporte['cod_transporte'];
if($transporte){
    echo'<script type="text/javascript"> alert("Sucesso!"); window.location.href="../View/index.php?escolher_doacao=true";</script>';
}else if($transporte == false){
    session_destroy();
    echo'<script type="text/javascript"> alert("Não te encontramos, tente novamente ou faça seu cadastro!"); window.location.href="../View/index.php";</script>';
}