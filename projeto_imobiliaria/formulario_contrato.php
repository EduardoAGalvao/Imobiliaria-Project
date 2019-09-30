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
    <meta name="description" content="Fechamento de contratos no sistema de gerenciamento imobiliário."/>

    <title>Primeiro Andar - Cadastro de Contratos</title>
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
          <div class="section">
            
            <div id="formulario_banco">
              <h1>Fechamento de Contrato</h1>
              <form method="post" action="./db/salvarContrato.php" name="frm_banco" id="frm_banco">
                <div id="div_tipo_imovel">
                  <label>Tipo de imóvel:</label>
                  <select name="slt_tipo_imovel" id="slt_tipo_imovel" required>
                    <option label="Tipo do imóvel">Selecione</option>
                    <option value="casa">Casa</option>
                    <option value="apartamento">Apartamento</option>
                  </select>
                </div>
                <div id="div_imoveis">
                  <?php
                  
                    $sql = "SELECT * FROM tbl_imovel i JOIN tbl_endereco e ON i.id_endereco_imovel = e.id_endereco JOIN tbl_estado est ON e.id_estado = est.id_estado WHERE i.id_imovel NOT IN (SELECT id_imovel FROM tbl_imovel_cliente WHERE data_final IS NULL) AND i.data_exclusao_imovel IS NULL;";
                            
                    $select = mysqli_query($conexao, $sql);
                
                    //Converte os dados do BD em array associativo
                    while($dados_imovel = mysqli_fetch_assoc($select)){
                      
                  ?>
                  
                    <div class="imovel_contrato imovel_<?= strtolower($dados_imovel['tipo'])?>">
                      <input type="radio" name="rdo_imovel" value="<?= $dados_imovel['id_imovel'] ?>">
                      <label><?=$dados_imovel['logradouro'] . ", ". $dados_imovel['numero'] . ". " . $dados_imovel['cidade'] . "-" . 
                      $dados_imovel['sigla'] . ". CEP: " . $dados_imovel['cep'];?></label>
                    </div>
                  
                  <?php
                      
                    }
                  
                  ?>
                </div>
                <div id="div_cpf">
                  <label>CPF do Cliente:</label>
                  <input class="cpf" placeholder="Ex: 123.123.123-12" maxlength="14" type="text" name="txt_cpf" id="txtCpf" required/>
                </div>
                <div id="btn_acoes">
                  <input class="botao botaoSalvar" type="submit" name="btnSalvar" value="Inserir">
                </div>
              </form>
            </div>
            
            <div id="consulta_banco">
              <h1>Relatórios de Contrato</h1>
              <table >
                <tr>
                  <th>Cód. Contrato</th>
                  <th>Cliente</th> 
                  <th>Tipo de Imóvel</th>
                  <th>Endereço</th>
                  <th>Data de Início</th>
                  <th>Opções</th>
                </tr>
                
                <?php
                                    
                  //Select para trazer todos os dados
                  $sql = "SELECT * FROM tbl_imovel_cliente ic JOIN tbl_cliente c ON c.id_cliente = ic.id_cliente JOIN tbl_imovel i ON i.id_imovel = ic.id_imovel JOIN tbl_endereco e ON i.id_endereco_imovel = e.id_endereco JOIN tbl_estado est ON e.id_estado = est.id_estado WHERE ic.data_final IS NULL";
                
                  //Executa o script no BD
                  $select = mysqli_query($conexao, $sql);
                
                  //Converte os dados do BD em array associativo
                  while($dados_contrato = mysqli_fetch_assoc($select)){
                                                                     
                ?>
                
                <tr>
                  <td><?= $dados_contrato['cod_contrato']; ?></td>
                  <td><?= $dados_contrato['nome_cliente']; ?></td> 
                  <td><?= $dados_contrato['tipo']; ?></td>
                  <td><?= $dados_contrato['logradouro'] . ", ". $dados_contrato['numero'] . ". <br>" . $dados_contrato['cidade'] . "-" . 
                  $dados_contrato['sigla'] . ". CEP:" . $dados_contrato['cep']; ?></td>
                  <?php
                    $data_inicio = explode("-", $dados_contrato['data_inicio']);
                    $data_inicio = $data_inicio[2]."/".$data_inicio[1]."/".$data_inicio[0];
                  ?>
                  <td><?= $data_inicio ?></td>
                  
                  <td class="opcoes_acao">
                    <a onclick="return confirm('Deseja realmente excluir o registro?');" href="db/encerrarContrato.php?modo=excluir&codigo=<?= $dados_contrato['cod_contrato'];?>">
                      <div class="btn_excluir"></div>
                    </a>
                    <a href="contrato.php?codigo=<?= $dados_contrato['cod_contrato'];?>">
                      <div class="btn_visualizar"></div>
                    </a>
                  </td>
                </tr>
                
                <?php
                  
                  }
                                    
                ?>
              </table>
            </div>
            
          </div>
          
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