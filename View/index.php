<?php 

ini_set('display_errors', 'off');
include_once("../Model/conexao.php");
include_once("../Model/bancoTransporte.php");
include_once("../Model/bancoDoacao.php");
include_once("../Model/bancoDoador.php");

include_once("../Controller/escolheDoacaoController.php");
include_once("../Controller/escolhidasDoacaoController.php");
include_once("../Controller/minhasDoacoesController.php");

if (isset($_GET['cadastrar_doacao']) || isset($_GET['escolher_doacao']) || isset($_GET['escolhidas_doacao'])|| isset($_GET['minhas_doacao'])) {
    session_start();
    
}else{
    session_unset();
    session_destroy();

}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto Elo Amor</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jaro:opsz@6..72&family=Jersey+25+Charted&family=Roboto:wght@300;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../style/stylesheet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-syD8S7O4U0+Ub+dYkSvS+eIpBp64dp+NyoHzU8+XUfeDcgN/PLcCgq5T7jvM/ncK" crossorigin="anonymous">

</head>
<body>
    <img class="marcadagua" src="../img/logo.png"/>  
    <div class="container"> 
        <div class="sidebarDoar">
            <h1>Doar</h1>
            <p class="voluntarios">
            <?php echo isset($_GET['cadastrar_doacao']) ? 'Cadastre uma Doação' :'Se você veio até aqui porque pode contribuir com algum item, Clique no Botão Abaixo &#x2B07;'?>
            </p>
            <button type="button" class="btn_doar">
                <div class="bnt_ajudar">
                </div>
            </button>
           
        </div>
        <div class="overlay_doar"><!--div sobreposicao-->
            <a href="index.php"class="close_btn_d">&#10006;</A>
            <h2>Já tem cadastro?</h2>
            <div class="form_doacao">
                <form action="../Controller/conferirDoadorController.php"method="POST">
                    <label class="form" for ="teldoador"> Digite seu celular: </label>
                        <input type="text" class="telefone" name="teldoador" placeholder="Seu celular" oninput="validarTelefone(this)" required>
                        <button type="submit" class="btnCad">Entrar</button> 
                </form>
                <h2>Não? Olá, quem é você? </h2>
                <form action="../Controller/adicionaDoadorController.php" method="POST"> 
                        <label class="form" for ="nomedoador">Seu nome:  </label>
                            <input type="text" name="nomedoador" placeholder="Seu Nome" required>

                            <label class="form" for ="teldoador">Seu celular:  </label>
                            <input type="text" name="teldoador" placeholder="Seu celular" oninput="validarTelefone(this)" onblur="verificarTelefone(this)" required>
        
                            <label class="form"for ="enderecodoador">Endereço para retirar a doação:</label>
                            <input type="text" name="enderecodoador" placeholder="Endereço para retirar doação" required>
                                                         
                            <label class="form" for="fotoDoador">Sua foto: (se quiser)</label>
                            <div class="perfil">
                                <label  for="fotodoador"></label>
                                <input type="file" id="fotodoador" name="fotodoador" accept="image/*">
                            </div>

                        <label class="form"for ="btnCad"></label>
                        <button type="submit" class="btnCad">Cadastrar-se</button>        
                </form>
            </div>
                
        </div>
        <div class="overlay_doacao" style="display:<?php echo isset($_GET['cadastrar_doacao']) ? 'block' : 'none'; ?>">
            <div class="telas_doacao" max>
                <a href="index.php?cadastrar_doacao=true" class="<?php echo isset ($_GET['cadastrar_doacao']) ? 'active' : ''; ?>">Nova Doação</a>
                <a href="index.php?minhas_doacao=true"class="<?php echo isset ($_GET['minhas_doacao']) ? 'active' : ''; ?>">Minhas Doações</a>
            </div>
            <a href="index.php"class="close_btn_d">&#10006;</A>
            <div class="form_doacao">
                <h1>Doações</h1>
                <form action="../Controller/adicionaDoacaoController.php" method="POST"> 
                        
                    <label class="form" for ="itemdoacao">Qual o nome do Item? </label>
                        <input type="text" name="itemdoacao" placeholder="Arroz, Feijão, Roupa etc..." required>

                        <label class="form" for ="quantidadedoacao">Quantidade em Peças, Kilos ou pacotes.  </label>
                        <input type="text" name="quantidadedoacao" placeholder="x pcs, x Kg, x pct." required>
        

                        <label class="form"for ="datadoacao">Dia e hora que a doacão pode ser retirada: </label>
                        <input type="datetime-local" name="datadoacao" required>
                                                         

                        <label class="form"for ="btnCad">
                            <button type="submit" class="btnCad">Doar</button> 
                        </label>        
                </form>
            </div> 
        </div>
        <div class="overlay_doacao" style="display:<?php echo isset($_GET['minhas_doacao']) ? 'block' : 'none'; ?>">
            <a href="index.php"class="close_btn_d">&#10006;</A>
            <div class="telas_doacao" max>
                <a href="index.php?cadastrar_doacao=true" class="<?php echo isset ($_GET['cadastrar_doacao']) ? 'active' : ''; ?>">Nova Doação</a>
                <a href="index.php?minhas_doacao=true"class="<?php echo isset ($_GET['minhas_doacao']) ? 'active' : ''; ?>">Minhas Doações</a>
            </div>
            
            <div class="grid_doacoes">
                <?php
                    if(isset($_SESSION['minhas']) && !empty( $_SESSION['minhas'])){
                        $nome = $_SESSION['nome_doador'];
                        echo "<h1 style = padding-top:5%;>$nome, Você tem ".count($_SESSION['minhas'])." doações cadastradas!</h1>";
                        foreach ($_SESSION['minhas'] as $minha):
                        $data_doacao = DateTime::createFromFormat('d/m/Y H:i',$minha['data_doacao_minha']);
                        $data_atual = new DateTime();
                        $vencimento = ($data_doacao < $data_atual) ? 'POXA. Não deu tempo de alguem buscar, Apague ou recadastre essa doação':$minha['data_doacao_minha'];   
                        
                        if (!empty($minha['telefone_transporte_minha'])) {
                            $nenhumEntregador = false; // Um entregador aceitou
                        }
                ?>
                <?php
                    if($data_doacao > $data_atual){
                ?>
                <div class="escolher" id="escolher_<?$minha['codigo_doacao_minha']?>" data-form-if="form_escolhida_<?=$minha['codigo_doacao_minha']?>">
                    <form id="form_escolhida_<?=$minha['codigo_doacao_minha']?>"action="../Controller/cancelarDoacaoController.php"method="POST"> 
                     
                        <h2 class="opcoes">Sua Docação de <br><span><?= $minha['item_doacao_minha']?></span></h2>
                        <h2 class="opcoes"><span><?= !empty($minha['telefone_transporte_minha']) ?$minha['nome_transporte_minha'].' Vai Transportar!' : 'Nenhum entregador aceitou ainda' ?></span></h2> 

                       
                        <input type="hidden" name="codigodoacao" value="<?=$minha['codigo_doacao_minha']?>">
                        
                        <div class="btn_confirmar"style="display:none;">
                            <h2 class="opcoes">item que você está doando: <br><span><?= $minha['item_doacao_minha']?></span></h2>
                            <h2 class="opcoes">Quem vai transportar: <span><?= $minha['nome_transporte_minha']?> </span></h2>
                            <h2 class="opcoes">tipo de veiculo: <br><span><?= $minha['veiculo_transporte_minha']?></span></h2>
                            <h2 class="opcoes">placa: <br><span><?= $minha['placa_transporte_minha']?></span></h2>
                            <h2 class="opcoes" style="margin-bottom:1.5%;">Telefone dele(a): <br><span><?= $minha['telefone_transporte_minha']?></span></h2>  
                            <h2 class="opcoes">Quantidade: <br><span><?= $minha['quantidade_doacao_minha']?></span></h2>
                            <h2 class="opcoes">Data que pode ser retirada a doação: <br>
                            <h1 style="color:black; text-align:center;">cancelar Doação?</h1>
                            <button type="submit" class="btnCad" style="font-size:40pt;">Sim</button>
                            <button id="btnNao" type="button" class="btnNao"style="font-size:40pt;">Não</button>
                        </div>              
                    </form>  
                </div>
                <?php
                }else{
                ?>
                <div class="escolher" style="border: 10px solid red;" id="escolher_<?$minha['codigo_doacao_minha']?>" data-form-if="form_escolhida_<?=$minha['codigo_doacao_minha']?>">
                    <h2 class="opcoes"> <span style="color:red;">Vencida</span><br> Doação de <br><span><?=$minha['item_doacao_minha']?></span><br>Esta com a data de retirada vencida</h2>
                    <h2>Atualize a data! <br><span style="color:red;"><?=$minha['data_doacao_minha']?></span></h2>
               
                </div>
                <?php
                }
                endforeach;
                $_SESSION['minhas']=[];
                }else{
                ?>
                <h1 style="padding:30%;">Você não tem doações cadastradas!</h1>
                <?php
                    }
                ?>       
            </div>
        </div>
        <div class="content">
            <p style="font-size:10pt">Ong Ação Vida Apresenta:</p>
            <h1>Projeto Elo Amor</h1>
            <p>
                Muitas vezes queremos ser solidarios, mas nos faltam recursos, ou tempo para contribuir. Pensando nisso, criamos este meio onde a solidariedade se completa. Por aqui, você pode ajudar de duas maneiras,  cadastrando uma doação que deseja fazer, que ficara disponivel para que os voluntarios a transportar doaçãoes possam vizualizar e fazer o transporte, ou sendo este voluntario que fara o transporte!

                <h2>Eai, como pode ajudar quem mais precisa?</h2>
            </p>
        </div>
        <div class="sidebarTransportar">
            <h1>Transportar</h1>
            <p class="voluntarios">
                Se você pode ajudar ao proximo se disponibilizando para o transporte de algum item doado, Cique no Botão Abaixo &#x2B07;
            </p>
            <button type="button" class="btn_transportar">
                <div class="bnt_ajudar">
                </div>
            </button>
        </div>
        <div class="overlay_transportar">
            <h2>Já tem cadastro?</h2>
                <form action="../Controller/conferirTransporteController.php"method="POST">
                    <label class="form" for ="teltransporte"> Digite seu celular: </label>
                    <input type="text" class="telefone" name="teltransporte" placeholder="Seu celular" oninput="validarTelefone(this)" required>
                    <button type="submit" class="btnCad">Entrar</button> 
                </form>
            <h2>Não? Olá, quem é você? </h2>
            <div class="form_transporte">
                <form action="../Controller/adicionaTransporteController.php" method="POST"> 
        
                        <label class="form" for ="nometransporte">Seu nome:  </label>
                        <input type="text" name="nometransporte" placeholder="Seu Nome" required>

                        <label class="form" for ="teltransporte">Seu celular:  </label>
                        <input type="text" name="teltransporte" maxlength="11" placeholder="Seu celular" oninput="validarTelefone(this)" onblur="verificarTelefone(this)" required>
        

                        <label class="form"for ="veiculotransporte">Como você vai transportar a doação?</label>
                        <select id="veiculotransporte" name="veiculotransporte">
                            <option value="carro" selected>Carro</option>
                            <option value="moto">Moto</option>
                            <option value="bicicleta">Bicicleta</option>
                            <option value="ape">a Pé</option>
                        </select>

                        <label class="form"for ="placatransporte">Placa do veiculo (se não houver digitar N/A):</label>
                        <input type="text" name="placatransporte" placeholder="Digite a placa" required>
                                                         
                        <label class="form" for="fototransporte">Sua foto: (se quiser)</label>
                        <div class="perfil">
                            <label  for="fototransporte"></label>
                            <input type="file" id="fototransporte" name="fototransporte" accept="image/*">
                        </div>

                        <label class="form"for ="btnCad"></label>
                        <button type="submit" class="btnCad">Cadastrar-se</button>        
                </form>
            </div>
            <a href="index.php"class="close_btn">&#10006;</A>
        </div>
        <div class="overlay_escolher" style="display:<?php echo isset($_GET['escolher_doacao']) ? 'block' : 'none'; ?>">
            <div class="telas_transporte"  style="display:<?php echo isset($_GET['escolher_doacao']) ? 'block' : 'none'; ?>">
                <a href="index.php?escolher_doacao=true"  class="<?php echo isset ($_GET['escolher_doacao']) ? 'active' : ''; ?>">Escolha uma Doação</a>
                <a href="index.php?escolhidas_doacao=true"id="escolhidas_doacao"class="<?php echo isset ($_GET['escolhidas_doacao']) ? 'active' : ''; ?>">Minhas Entregas</a>   
            </div>
            <a href="index.php"class="close_btn">&#10006;</A>
            <div class="grid_doacoes">
                <?php
                    if(isset($_SESSION['doacoes']) && !empty( $_SESSION['doacoes'])){
                        
                        $nome = $_SESSION['nome_transporte'];
                        echo "<h1 style = padding-top:5%;>Olá $nome, temos ".count($_SESSION['doacoes'])." doações esperando um entregador! </h1>";
                        foreach ($_SESSION['doacoes'] as $doacao):
                            $data_doacao = DateTime::createFromFormat('d/m/Y H:i',$doacao['data_doacao']);
                            $data_atual = new DateTime();
                            $quantidade = ($data_doacao > $data_atual);
                           
                            if($data_doacao > $data_atual){
                ?>
                <div class="escolher" id="escolher_<?$doacao['codigo_doacao']?>" data-form-if="form_escolhida_<?=$doacao['codigo_doacao']?>">
                    <form id="form_escolher_<?=$doacao['codigo_doacao']?>"action="../Controller/confirmadaDoacaoController.php"method="POST">
                        <h2 class="opcoes">item para transporte: <br><span><?= $doacao['item_doacao']?></span></h2>
                        <h2 class="opcoes">Endereço para retirar doação:<br><span><?= $doacao['endereco_doacao']?></span></h2>  
                        <input type="hidden" name="codigodoacao" value="<?=$doacao['codigo_doacao']?>">
                        <div class="btn_confirmar"style="display:none;">
                            <h2 class="opcoes">item para transporte: <br><span><?= $doacao['item_doacao']?></span></h2>
                            <h2 class="opcoes">Quantidade: <br><span><?= $doacao['quantidade_doacao']?></span></h2>
                            <h2 class="opcoes">Endereço para retirar doação:<br><span><?= $doacao['endereco_doacao']?></span></h2>
                            <h2 class="opcoes">Nome Doador:<br> <span><?= $doacao['nome_doador']?></span></h2>
                            <h2 class="opcoes">Telefone Doador: <br><span><?= $doacao['telefone_doador']?></span></h2>
                            <h2 class="opcoes">Data que pode ser retirada a doação: <br>
                            <h1 style="color:black; text-align:center;">Assumir entrega?</h1>
                            <button type="submit" class="btnCad" style="font-size:40pt;">Sim</button>
                            <button id="btnNao" type="button" class="btnNao"style="font-size:40pt;">Não</button>
                        </div>               
                    </form>
                </div>
                    
                <?php
                            }else{
                                
                            }
                    endforeach;
                    $_SESSION['doacoes']=[];
                    }else{
                 ?>
                 <h1 style="padding:30%;">Não ha doações disponiveis</h1>
                 <?php
                    }
                 ?>
            </div>
                 
        </div>
        <div class="overlay_escolher"style="display:<?php echo isset($_GET['escolhidas_doacao']) ? 'block' : 'none'; ?>">
            <div class="telas_transporte" max>
                <a href="index.php?escolher_doacao=true" class="<?php echo isset ($_GET['escolher_doacao']) ? 'active' : ''; ?>">Escolha uma Doação</a>
                <a href="index.php?escolhidas_doacao=true"class="<?php echo isset ($_GET['escolhidas_doacao']) ? 'active' : ''; ?>">Minhas Entregas</a>
            </div>
            <a href="index.php"class="close_btn">&#10006;</A>
            <div class="grid_doacoes">
                <?php
                    if(isset($_SESSION['escolhidas']) && !empty( $_SESSION['escolhidas'])){
                        $nome = $_SESSION['nome_transporte'];
                        echo "<h1 style = padding-top:5%;padding-right:20%>$nome, Você tem ".count($_SESSION['escolhidas'])." doações a entregar!</h1>";
                        foreach ($_SESSION['escolhidas'] as $meus):
                        $data_doacao = DateTime::createFromFormat('d/m/Y H:i',$meus['data_doacao_escolhida']);
                        $data_atual = new DateTime();
                        if($data_doacao > $data_atual){
                ?>
                <div class="escolher" id="escolher_<?$meus['codigo_doacao_escolhida']?>" data-form-if="form_escolhida_<?=$meus['cod_doacao_escolhida']?>">
                    <form id="form_escolhida_<?=$meus['codigo_doacao_escolhida']?>"action="../Controller/cancelarEntregaController.php"method="POST"> 

                        <h2 class="opcoes">Busque dia <br>
                        <span><?=$meus['data_doacao_escolhida'] ?></span></h2>    
                        <h2 class="opcoes">O item <br><span><?= $meus['item_doacao_escolhida']?></span></h2>
                        <h2 class="opcoes">Aqui:<br><span><?= $meus['endereco_doacao_escolhida']?></span></h2>


                           
                        <input type="hidden" name="codigodoacao" value="<?=$meus['codigo_doacao_escolhida']?>">
                        <div id="btn_confirmar" class="btn_confirmar"style="display:none;">
                            <h2 class="opcoes">Data para retirada da doação: <br><span><?=$meus['data_doacao_escolhida']?></span></h2>
                            <h2 class="opcoes">Item da Doação: <br><span><?= $meus['item_doacao_escolhida']?></span></h2>
                            <h2 class="opcoes">Nome Doador:<br> <span><?= $meus['nome_doador_escolhida']?></span></h2>
                            <h2 class="opcoes">Endereço para retirar doação:<br><span><?= $meus['endereco_doacao_escolhida']?></span></h2>
                            <h2 class="opcoes">Telefone Doador: <br><span><?= $meus['telefone_doador_escolhida']?></span></h2>
                            <h2 class="opcoes">item para transporte: <br><span><?= $meus['item_doacao_escolhida']?></span></h2>
                            <h2 class="opcoes">Quantidade: <br><span><?= $meus['quantidade_doacao_escolhida']?></span></h2>
                            <h1 style="color:black; text-align:center;">cancelar entrega?</h1>
                            <button type="submit" class="btnCad" style="font-size:40pt;">Sim</button>
                            <button id="btnNao" type="button" class="btnNao"style="font-size:40pt;">Não</button>
                        </div>               
                    </form>
                    
                </div>
                    
                <?php
                        }else{}
                    endforeach;
                    $_SESSION['escolhidas']=[];
                    }else{
                ?>
                <h1 style="padding:30%;">Você não tem doações escolhidas</h1>
                <?php
                    }
                ?>
            </div>
        </div>
             
    </div>
    <script src="js.js"></script>
    <script>
    function validarTelefone(input) {
        var telefone = input.value.replace(/\D/g,''); // Remove todos os caracteres que não são dígitos
        input.value = telefone
        if(telefone.length == 11){
            input.value = telefone.replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3'); // Atualiza o valor do campo apenas com os dígitos
        }
    }

    function verificarTelefone(input) {
        var telefone = input.value.replace(/\D/g,''); // Remove todos os caracteres que não são dígitos
        
        if (telefone.length < 11) {
            alert("Por favor, insira um número de telefone válido com pelo menos 11 dígitos.");
            input.value="00000000000".replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3'); // Atualiza o valor do campo apenas com os dígitos;
            input.focus(); // Redireciona o foco de volta para o campo de telefone
        }
    }
   

</script>

</body>
</html>
