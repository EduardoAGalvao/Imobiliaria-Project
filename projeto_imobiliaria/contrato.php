<?php

require_once('./db/conexao.php');

//Chamada para função de conexão com o MySQL
$conexao = conexaoMysql();

?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Eduardo Galvão">
    <meta name="copyright" content="Eduardo Galvão © 2019"/>
    <meta name="description" content="Relatório contratual fechado no sistema de gerenciamento imobiliário."/>

    <title>Primeiro Andar - Relatório Contratual</title>
    <link rel="icon" href="./icon/favicon.png">

    <!-- CSS -->
    <link href="./css/style.css" rel="stylesheet">

    <!--JS-->
    <script src="./js/jquery.min.js"></script>
    <script src="./js/validacao.js"></script>
    <script src="./js/action.js"></script>

  </head>
<body>

  <div class="container">

    <!-- CABEÇALHO -->
    <header class="background">
      <div class="section">
        <div class="conteudo center">

          <!--MENU-->
          <div class="menu_logo">
            <a href="index.html"><div class="logo"></div></a>
            <nav>
              <ul id="menu_principal">
                <li><a href="./formulario_cliente.php">Clientes</a></li>
                <li><a href="./formulario_proprietario.php">Proprietários</a></li>
                <li><a href="./formulario_imovel.php">Imóveis</a></li>
                <li><a href="./formulario_contrato.php">Contratos</a></li>
              </ul>
            </nav>
          </div>  

        </div>
      </div>
    </header> 


      <!--CONTEÚDO-->
      <div id="conteudo_projetos">
        <div class="conteudo center">
          
          <a href="./formulario_contrato.php" id="contrato_link">Voltar para os contratos vigentes</a>
          
          <section>
            
            <h1>Relatório Contratual</h1>
            
            <?php
            
              if(isset($_GET['codigo'])){
                $codigo_contrato = $_GET['codigo'];
                
                $sql = "SELECT * FROM tbl_imovel_cliente ic JOIN tbl_imovel i ON ic.id_imovel = i.id_imovel JOIN tbl_proprietario p ON i.id_proprietario = p.id_proprietario JOIN tbl_cliente c ON c.id_cliente = ic.id_cliente JOIN tbl_endereco e ON i.id_endereco_imovel = e.id_endereco JOIN tbl_estado est ON e.id_estado = est.id_estado WHERE ic.cod_contrato =".$codigo_contrato.";";
                
                $select = mysqli_query($conexao, $sql);
                
                if($dados_contrato = mysqli_fetch_assoc($select)){
                 
                  //Dados do documento
                  $dataInicio = explode("-", $dados_contrato['data_inicio']);
                  $dataInicio = $dataInicio[2]."/".$dataInicio[1]."/".$dataInicio[0];
                  
                  //Dados do Imóvel
                  $matriculaImovel = $dados_contrato['matricula'];
                  $tipoImovel = $dados_contrato['tipo'];
                  $enderecoImovel = $dados_contrato['logradouro'] . ", ".       $dados_contrato['numero'] . ". <br>" . $dados_contrato['cidade'] . "-" . 
                  $dados_contrato['sigla'] . ". CEP: " . $dados_contrato['cep'];
                  
                  //Dados do Cliente
                  $nomeCliente = $dados_contrato['nome_cliente'];
                  $cpfCliente = $dados_contrato['cpf_cliente'];
                  $idadeCliente = $dados_contrato['idade'];
                  $telefoneCliente = $dados_contrato['telefone_cliente'];
                  
                  //Dados do Proprietário
                  $nomeProprietario = $dados_contrato['nome_proprietario'];
                  $cpfProprietario = $dados_contrato['cpf_proprietario'];
                  $telefoneProprietario = $dados_contrato['telefone_proprietario'];
                  $dataNascimentoProprietario = explode("-", $dados_contrato['data_nascimento']);
                  $dataNascimentoProprietario = $dataNascimentoProprietario[2]."/".$dataNascimentoProprietario[1]."/".$dataNascimentoProprietario[0];
                }
                
              }
            
            ?>
            
            <div id="dados_documento">
              <div id="dados_contrato">
                <h2>CÓDIGO DO CONTRATO: <?= isset($codigo_contrato) ? $codigo_contrato : "" ?> </h2>
                <h2>Data de início: <?= isset($dataInicio) ? $dataInicio : "" ?></h2>
              </div>
              <div id="dados_imovel">
                <h2>Dados do Imóvel</h2>
                <p>Matrícula: <?= isset($matriculaImovel) ? $matriculaImovel : "" ?></p>
                <p><?= isset($tipoImovel) ? $tipoImovel : "" ?></p>
                <p><?= isset($enderecoImovel) ? $enderecoImovel : "" ?></p>
              </div>
              <div id="dados_cliente">
                <h2>Dados do Cliente Contratante</h2>
                <p>Nome: <?= isset($nomeCliente) ? $nomeCliente : "" ?></p>
                <p>CPF: <?= isset($cpfCliente) ? $cpfCliente : "" ?></p>
                <p>Idade: <?= isset($idadeCliente) ? $idadeCliente . " anos" : "" ?></p>
                <p>Telefone: <?= isset($telefoneCliente) ? $telefoneCliente : "" ?></p>
              </div>
              <div id="dados_proprietario">
                <h2>Dados do Proprietário</h2>
                <p>Nome: <?= isset($nomeProprietario) ? $nomeProprietario : "" ?></p>
                <p>CPF: <?= isset($cpfProprietario) ? $cpfProprietario : "" ?></p>
                <p>Data de Nascimento: <?= isset($dataNascimentoProprietario) ? $dataNascimentoProprietario : "" ?></p>
                <p>Telefone: <?= isset($telefoneProprietario) ? $telefoneProprietario : "" ?></p>
              </div>
            </div>
                        
          </section>
        </div>
      </div>

      <!--FOOTER-->
      <footer>
        <div class="conteudo center">
        </div>
      </footer>

    </div>
  </body>
</html>