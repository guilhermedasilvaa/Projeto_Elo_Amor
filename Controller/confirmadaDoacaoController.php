<?php
session_start();
include_once("../Model/conexao.php");
include_once("../Model/bancoDoacao.php");
include_once("../Model/bancoTransporte.php");


extract($_REQUEST, EXTR_OVERWRITE);

if(doacaoEscolhida($conexao,$codigodoacao)){
    echo'<script type="text/javascript"> alert("Doação escolhida!");window.location.href="../View/index.php?escolhidas_doacao=true";</script>'; 
   
    
}else{
    
    echo'<script type="text/javascript"> alert("verifique se colocou todos os dados corretamente, e tente novamente!");</script>';
    
}
?>