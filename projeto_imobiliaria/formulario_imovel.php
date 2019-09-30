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
    <meta name="description" content="Cadastro de imóveis em sistema de gerenciamento imobiliário."/>

    <title>Primeiro Andar - Cadastro de Imóveis</title>
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
                $endereco = $_GET['id_endereco'];
                
                //Ativa o recurso de variável de sessão, pois alguns servidores tem o mesmo desligado
                session_start();
                
                //Guardando em variável de sessão o código do registro
                $_SESSION['id_imovel'] = $codigo;
                $_SESSION['id_endereco'] = $endereco;
                
                //Script a ser executado no BD
                $sql = "SELECT * FROM tbl_imovel i JOIN tbl_endereco e ON i.id_endereco_imovel = e.id_endereco JOIN tbl_estado est ON e.id_estado = est.id_estado JOIN tbl_proprietario p ON i.id_proprietario = p.id_proprietario WHERE i.id_imovel =".$codigo;
                
                //Executa o script no BD
                $select = mysqli_query($conexao, $sql);
                
                //Converte os dados do BD em array associativo
                if($dados_imovel = mysqli_fetch_assoc($select)){
                  
                  //Resgatando dados do BD e colocando em variáveis locais
                  $txtCpf = $dados_imovel['cpf_proprietario'];
                  $txtTipoImovel = $dados_imovel['tipo'];
                  $txtLogradouro = $dados_imovel['logradouro'];
                  $txtNumero = $dados_imovel['numero']; 
                  $txtCidade = $dados_imovel['cidade']; 
                  $txtEstado = $dados_imovel['sigla'];
                  $txtCep = $dados_imovel['cep'];
                }
                                
              };
            
            ?>
            
            <div id="formulario_banco">
              <h1>Cadastro de Imóveis</h1>
              <form method="post" action="./db/salvarImovel.php" name="frm_banco" id="frm_banco">
                <div id="div_cpf">
                  <label>CPF do Proprietário:</label>
                  <input class="cpf" placeholder="Ex: 123.123.123-12" maxlength="14" type="text" name="txt_cpf" id="txtCpf" value="<?= isset($txtCpf) ? $txtCpf : '' ?>" <?= isset($_GET['modo']) && $_GET['modo'] == 'editar' ? 'readonly' : ''?> required/>
                </div>
                <div id="div_tipo_imovel">
                  <label>Tipo de imóvel:</label>
                  <select name="slt_tipo_imovel" required>
                    <option label="Tipo do imóvel"></option>
                    <option  <?= (isset($txtTipoImovel) && $txtTipoImovel == 'Casa') ? "selected" : ""?> value="Casa">Casa</option>
                    <option <?= (isset($txtTipoImovel) && $txtTipoImovel == 'Apartamento') ? "selected" : ""?> value="Apartamento">Apartamento</option>
                  </select>
                </div>
                <div id="div_endereco">
                  <label>Logradouro:</label>
                  <input class="alfanumerico" maxlength="200" placeholder="Ex: Avenida Antônio João" type="text" name="txt_logradouro" value="<?= isset($txtLogradouro) ? $txtLogradouro : '' ?>" required>
                  <label>Número:</label>
                  <input class="alfanumerico" placeholder="Ex: 123" type="text" name="txt_numero" value="<?= isset($txtNumero) ? $txtNumero : '' ?>" required>
                  <label>Cidade:</label>
                  <input class="alfanumerico" maxlength="100" placeholder="Ex: Itapevi" type="text" name="txt_cidade" value="<?= isset($txtCidade) ? $txtCidade : '' ?>" required>
                  <label>Estado:</label>
                  <select name="slt_estado" required>
                    <option label="Escolha do Estado"></option>
                    <option  <?= (isset($txtEstado) && $txtEstado == 'SP') ? "selected" : ""?> value="SP">SP</option>
                    <option <?= (isset($txtEstado) && $txtEstado == 'MG') ? "selected" : ""?> value="MG">MG</option>
                  </select>
                  <label>CEP:</label>
                  <input class="cep" placeholder="01231-234" maxlength="9" type="text" name="txt_cep" value="<?= isset($txtCep) ? $txtCep : '' ?>" required>
                </div>
                <div id="btn_acoes">
                  <input class="botao botaoSalvar" type="submit" name="btnSalvar" value="<?= isset($_GET['modo']) && $_GET['modo'] == 'editar' ? "Atualizar" : "Inserir" ?>">
                  
                  <input class="botao botaoLimpar" type="reset" name="btnLimpar" value="<?= isset($_GET['modo']) && $_GET['modo'] == 'editar' ? 'Cancelar' : 'Limpar' ?>"/>
                </div>
              </form>
            </div>
            
            <div id="consulta_banco">
              <h1>Consulta de Imóveis</h1>
              <table >
                <tr>
                  <th>Matrícula</th>
                  <th>Tipo</th> 
                  <th>Endereço</th>
                  <th>Proprietário</th>
                  <th>Contato</th>
                  <th>Opções</th>
                </tr>
                
                <?php
                                    
                  //Select para trazer todos os dados
                  $sql = "SELECT * FROM tbl_imovel i JOIN tbl_endereco e ON i.id_endereco_imovel = e.id_endereco JOIN tbl_estado est ON e.id_estado = est.id_estado JOIN tbl_proprietario p ON i.id_proprietario = p.id_proprietario WHERE i.data_exclusao_imovel IS NULL";
                
                  //Executa o script no BD
                  $select = mysqli_query($conexao, $sql);
                
                  //Converte os dados do BD em array associativo
                  while($dados_imovel = mysqli_fetch_assoc($select)){
                                                     
                ?>
                
                <tr>
                  <td><?= $dados_imovel['matricula']; ?></td>
                  <td><?= $dados_imovel['tipo']; ?></td> 
                  <td><?= $dados_imovel['logradouro'] . ", ". $dados_imovel['numero'] . ". <br>" . $dados_imovel['cidade'] . "-" . 
                  $dados_imovel['sigla'] . ". CEP: " . $dados_imovel['cep'] ?></td>
                  <td><?= $dados_imovel['nome_proprietario']; ?></td>
                  <td><?= $dados_imovel['telefone_proprietario']; ?></td>
                  <td class="opcoes_acao">
                    <a href="formulario_imovel.php?modo=editar&codigo=<?= $dados_imovel['id_imovel'];?>&id_endereco=<?= $dados_imovel['id_endereco_imovel'];?>">
                      <div class="btn_editar"></div>
                    </a>
                    <a onclick="return confirm('Deseja realmente excluir o registro?');" href="db/removerImovel.php?modo=excluir&codigo=<?= $dados_imovel['id_imovel'];?>&id_endereco=<?= $dados_imovel['id_endereco_imovel'];?>">
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