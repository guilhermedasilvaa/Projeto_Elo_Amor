<?php
 session_start();
include_once("../Model/conexao.php");
include_once("../Model/bancoDoador.php");
extract($_REQUEST, EXTR_OVERWRITE);
$doador = loginDoador($conexao, $teldoador);
$_SESSION['nome_doador'] = $doador['nome_doador'];
$_SESSION['codigo_doador'] = $doador['cod_doador'];
if($doador){
    echo'<script type="text/javascript"> alert("Sucesso!"); window.location.href="../View/index.php?cadastrar_doacao=true";</script>';
}else if($doador == false){
    session_destroy();
    echo'<script type="text/javascript"> alert("Não te encontramos, tente novamente ou faça seu cadastro!"); window.location.href="../View/index.php";</script>';
}