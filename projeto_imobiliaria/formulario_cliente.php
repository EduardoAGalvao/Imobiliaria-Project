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
    <meta name="copyright" content="Eduardo Galvão © 2019 "/>
    <meta name="description" content="Cadastro de clientes no sistema de gerenciamento imobiliário."/>

    <title>Primeiro Andar - Cadastro de Clientes</title>
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
            
            <?php
            
              //Checando se o botão editar foi clicado e o modo foi setado
              //Valida se a ação de modo é para editar
              if( (isset($_GET['modo'])) && $_GET['modo'] == 'editar'){
                
                //Código do item a ser selecionado
                $codigo = $_GET['codigo'];
                
                //Ativa o recurso de variável de sessão, pois alguns servidores tem o mesmo desligado
                session_start();
                
                //Guardando em variável de sessão o código do registro
                $_SESSION['id'] = $codigo;
                
                //Script a ser executado no BD
                $sql = "SELECT * FROM tbl_cliente WHERE id_cliente = $codigo";
                
                //Executa o script no BD
                $select = mysqli_query($conexao, $sql);
                
                //Converte os dados do BD em array associativo
                if($cliente = mysqli_fetch_assoc($select)){
                  
                  //Resgatando dados do BD e colocando em variáveis locais
                  $nome = $cliente['nome_cliente'];
                  $cpf = $cliente['cpf_cliente'];
                  $idade = $cliente['idade'];
                  $telefone = $cliente['telefone_cliente'];
                                    
                }
                                
              };
            
            ?>
            
            <div id="formulario_banco">
              <h1>Cadastro de Clientes</h1>
              <form method="post" action="./db/salvarCliente.php" name="frm_banco" id="frm_banco">
                <div id="div_nome">
                  <label>Nome:</label>
                  <input class="texto" maxlength="100" placeholder="Ex: Pedro da Silva" type="text" name="txt_nome" id="txtNome" value="<?= isset($nome) ? $nome : '' ?>" required/>
                </div>
                <div id="div_cpf">
                  <label>CPF:</label>
                  <input class="cpf" placeholder="Ex: 123.123.123-12" maxlength="14" type="text" name="txt_cpf" id="txtCpf" value="<?= isset($cpf) ? $cpf : '' ?>" required/>
                </div>
                <div id="div_idade">
                  <label>Idade:</label>
                  <input class="numero" placeholder="Ex: 24" type="text" name="txt_idade" id="txtIdade" value="<?= isset($idade) ? $idade : '' ?>" required/>
                </div>
                <div id="div_telefone">
                  <label>Telefone:</label>
                  <input class="telefone" placeholder="Ex: 11 41444567" maxlength="13" type="text" name="txt_telefone" value="<?= isset($telefone) ? $telefone : '' ?>" required>
                </div>
                <div id="btn_acoes">
                  <input class="botao botaoSalvar" type="submit" name="btnSalvar" value="<?= isset($_GET['modo']) && $_GET['modo'] == 'editar' ? "Atualizar" : "Inserir" ?>">
                  
                  <input class="botao botaoLimpar" type="reset" name="btnLimpar" value="<?= isset($_GET['modo']) && $_GET['modo'] == 'editar' ? 'Cancelar' : 'Limpar' ?>"/>
                </div>
              </form>
            </div>
            
            <div id="consulta_banco">
              <h1>Consulta de Clientes</h1>
              <table >
                <tr>
                  <th>Nome</th>
                  <th>CPF</th> 
                  <th>Idade</th>
                  <th>Telefone</th>
                  <th>Opções</th>
                </tr>
                
                <?php
                  
                  //Select para trazer todos os dados
                  $sql = "SELECT * FROM tbl_cliente WHERE data_exclusao_cliente IS NULL";
                
                  //Executa o script no BD e guarda o resultado
                  $select = mysqli_query($conexao, $sql);
                         
                    while($cliente = mysqli_fetch_array($select)){  
                                                     
                ?>
                
                <tr>
                  <td><?= $cliente['nome_cliente']; ?></td>
                  <td><?= $cliente['cpf_cliente']; ?></td> 
                  <td><?= $cliente['idade'] . " anos"; ?></td>
                  <td><?= $cliente['telefone_cliente']; ?></td>
                  <td class="opcoes_acao">
                    <a href="formulario_cliente.php?modo=editar&codigo=<?= $cliente['id_cliente'];?>">
                      <div class="btn_editar"></div>
                    </a>
                    <a onclick="return confirm('Deseja realmente excluir o registro?');" href="db/removerCliente.php?modo=excluir&codigo=<?= $cliente['id_cliente'];?>">
                      <div class="btn_excluir"></div>
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