<?php
session_start();
include_once("../Model/conexao.php");
include_once("../Model/bancoDoador.php");

extract($_REQUEST, EXTR_OVERWRITE);
if(inserirDoador($conexao, $nomedoador, $enderecodoador, $teldoador,$fotodoador)){
    $doador = loginDoador($conexao,$teldoador);
  
    if($doador){
        $_SESSION['codigo_doador'] = $doador['cod_doador'];
        $_SESSION['nome_doador'] = $doador['nome_doador'];
        
    }
    echo'<script type="text/javascript"> alert("Cadastrado!"); window.location.href="../View/index.php?cadastrar_doacao=true";</script>';
}else{
    session_destroy();
    echo'<script type="text/javascript"> alert("verifique se colocou todos os dados corretamente, e tente novamente!");window.location.href="../View/index.php";</script>';
    
}
?>