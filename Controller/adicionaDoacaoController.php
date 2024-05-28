<?php
session_start();
include_once("../Model/conexao.php");
include_once("../Model/bancoDoacao.php");

extract($_REQUEST, EXTR_OVERWRITE);
if(inserirDoacao($conexao, $itemdoacao, $quantidadedoacao, $datadoacao)){
    echo'<script type="text/javascript"> alert("Doação Cadastrada!");window.location.href="../View/index.php?cadastrar_doacao=true" ;</script>'; 
}else{
    
    echo'<script type="text/javascript"> alert("verifique se colocou todos os dados corretamente, e tente novamente!");</script>';
  
}
?>