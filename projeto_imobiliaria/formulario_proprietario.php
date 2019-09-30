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
    <meta name="description" content="Cadastro de proprietários em sistema de gerenciamento imobiliário."/>

    <title>Primeiro Andar - Cadastro de Proprietários</title>
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
                $id_endereco = $_GET['id_endereco'];
                
                //Ativa o recurso de variável de sessão, pois alguns servidores tem o mesmo desligado
                session_start();
                
                //Guardando em variável de sessão o código do registro
                $_SESSION['id_proprietario'] = $codigo;
                $_SESSION['id_endereco'] = $id_endereco;
                
                //Script a ser executado no BD
                $sql = "SELECT * FROM tbl_proprietario p JOIN tbl_endereco e ON p.id_endereco = e.id_endereco JOIN tbl_estado est ON e.id_estado = est.id_estado WHERE p.id_proprietario =".$codigo;
                
                //Executa o script no BD
                $select = mysqli_query($conexao, $sql);
                
                //Converte os dados do BD em array associativo
                if($proprietario = mysqli_fetch_assoc($select)){
                  
                  //Resgatando dados do BD e colocando em variáveis locais
                  $nome = $proprietario['nome_proprietario'];
                  $cpf = $proprietario['cpf_proprietario'];
                  $telefone = $proprietario['telefone_proprietario'];
                  
                  $data_nascimento = explode("-", $proprietario['data_nascimento']);
                  $data_nascimento = $data_nascimento[2]."/".$data_nascimento[1]."/".$data_nascimento[0];
                  
                  $txt_logradouro = $proprietario['logradouro'];
                  $txt_numero = $proprietario['numero'];
                  $txt_cidade = $proprietario['cidade'];
                  $txt_estado = $proprietario['sigla'];
                  $txt_cep = $proprietario['cep'];
                }
                                
              };
            
            ?>
            
            <div id="formulario_banco">
              <h1>Cadastro de Proprietários</h1>
              <form method="post" action="./db/salvarProprietario.php" name="frm_banco" id="frm_banco">
                <div id="div_nome">
                  <label>Nome:</label>
                  <input class="texto" maxlength="100" placeholder="Ex: Pedro da Silva" type="text" name="txt_nome" id="txtNome" value="<?= isset($nome) ? $nome : '' ?>" required/>
                </div>
                <div id="div_cpf">
                  <label>CPF:</label>
                  <input class="cpf" placeholder="Ex: 123.123.123-12" maxlength="14" type="text" name="txt_cpf" id="txtCpf" value="<?= isset($cpf) ? $cpf : '' ?>" required/>
                </div>
                <div id="div_nascimento">
                  <label>Data Nascimento:</label>
                  <input class="data_nascimento" maxlength="10" type="text" name="txt_nascimento" placeholder="Ex: 12/06/1980" value="<?= isset($data_nascimento) ? $data_nascimento : '' ?>" required>
                </div>
                <div id="div_telefone">
                  <label>Telefone:</label>
                  <input class="telefone" placeholder="Ex: 11 41444567" maxlength="13" type="text" name="txt_telefone" value="<?= isset($telefone) ? $telefone : '' ?>" required>
                </div>
                <div id="div_endereco">
                  <label>Logradouro:</label>
                  <input class="alfanumerico" maxlength="200" placeholder="Ex: Avenida Antônio João" type="text" name="txt_logradouro" value="<?= isset($txt_logradouro) ? $txt_logradouro : '' ?>" required>
                  <label>Número:</label>
                  <input class="alfanumerico" placeholder="Ex: 123" type="text" name="txt_numero" value="<?= isset($txt_numero) ? $txt_numero : '' ?>" required>
                  <label>Cidade:</label>
                  <input class="texto" maxlength="100" placeholder="Ex: Itapevi" type="text" name="txt_cidade" value="<?= isset($txt_cidade) ? $txt_cidade : '' ?>" required>
                  <label>Estado:</label>
                  <select name="slt_estado" required>
                    <option label="Motivo do contato"></option>
                    <option  <?= (isset($txt_estado) && $txt_estado == 'SP') ? "selected" : ""?> value="SP">SP</option>
                    <option <?= (isset($txt_estado) && $txt_estado == 'MG') ? "selected" : ""?> value="MG">MG</option>
                  </select>
                  <label>CEP:</label>
                  <input class="cep" placeholder="01231-234" maxlength="9" type="text" name="txt_cep" value="<?= isset($txt_cep) ? $txt_cep : '' ?>" required>
                </div>
                <div id="btn_acoes">
                  <input class="botao botaoSalvar" type="submit" name="btnSalvar" value="<?= isset($_GET['modo']) && $_GET['modo'] == 'editar' ? "Atualizar" : "Inserir" ?>">
                  
                  <input class="botao botaoLimpar" type="reset" name="btnLimpar" value="<?= isset($_GET['modo']) && $_GET['modo'] == 'editar' ? 'Cancelar' : 'Limpar' ?>"/>
                </div>
              </form>
            </div>
            
            <div id="consulta_banco">
              <h1>Consulta de Proprietários</h1>
              <table >
                <tr>
                  <th>Nome</th>
                  <th>CPF</th> 
                  <th>Telefone</th>
                  <th>Data Nascimento</th>
                  <th>Endereço</th>
                  <th>Opções</th>
                </tr>
                
                <?php
                  
                  //Select para trazer todos os dados
                  $sql = "SELECT * FROM tbl_proprietario p JOIN tbl_endereco e ON p.id_endereco = e.id_endereco JOIN tbl_estado est ON e.id_estado = est.id_estado WHERE p.data_exclusao_proprietario IS NULL";
                
                  //Executa o script no BD e guarda o resultado
                  $select = mysqli_query($conexao, $sql);
                         
                    while($proprietario = mysqli_fetch_array($select)){  
                                                     
                ?>
                
                <tr>
                  <td><?= $proprietario['nome_proprietario']; ?></td>
                  <td><?= $proprietario['cpf_proprietario']; ?></td> 
                  <td><?= $proprietario['telefone_proprietario']; ?></td>
                  <?php
                    $data_nascimento = explode("-", $proprietario['data_nascimento']);
                    $data_nascimento = $data_nascimento[2]."/".$data_nascimento[1]."/".$data_nascimento[0];
                  ?>
                  <td><?= $data_nascimento; ?></td>
                  <td><?= $proprietario['logradouro'] . ", ". $proprietario['numero'] . ". <br>" . $proprietario['cidade'] . "-" . 
                  $proprietario['sigla'] . ". CEP: " . $proprietario['cep']; ?></td>
                  <td class="opcoes_acao">
                    <a href="formulario_proprietario.php?modo=editar&codigo=<?= $proprietario['id_proprietario'];?>&id_endereco=<?= $proprietario['id_endereco'];?>">
                      <div class="btn_editar"></div>
                    </a>
                    <a onclick="return confirm('Deseja realmente excluir o registro?');" href="db/removerProprietario.php?modo=excluir&codigo=<?= $proprietario['id_proprietario'];?>&id_endereco=<?= $proprietario['id_endereco'];?>">
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