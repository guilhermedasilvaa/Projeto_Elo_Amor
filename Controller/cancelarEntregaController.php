<?php
session_start();
include_once("../Model/conexao.php");
include_once("../Model/bancoTransporte.php");


extract($_REQUEST, EXTR_OVERWRITE);

if(cancelarEntrega($conexao,$codigodoacao)){
    echo'<script type="text/javascript"> alert(" Entrega de Doação Cancelada!");window.location.href="../View/index.php?escolhidas_doacao=true";</script>'; 
   
    
}else{
    
    echo'<script type="text/javascript"> alert("verifique se colocou todos os dados corretamente, e tente novamente!");</script>';
    
}
?>