<?php
  
  //Declaração das variáveis
  $txtCpf = (string) null;
  $txtTipoImovel = (string) null;
  $txtLogradouro = (string) null;
  $txtNumero = (string) null;
  $txtCidade = (string) null;
  $txtEstado = (string) null;
  $txtCep = (string) null;
  
  //Inicializando $_SESSION
  session_start();
  
  //Validação para receber dados do form via POST
  if(isset($_POST['btnSalvar'])){
    
    //Importa o arquivo de conexão com BD
    require_once('conexao.php');
    
    //Abre a conexão com BD
    $conexao = conexaoMysql();
  
    $txtCpf = $_POST['txt_cpf'];
    $txtTipoImovel = $_POST['slt_tipo_imovel'];
    $txtLogradouro = $_POST['txt_logradouro'];
    $txtNumero = $_POST['txt_numero'];
    $txtCidade = $_POST['txt_cidade'];
    $txtEstado = $_POST['slt_estado'];
    $txtCep = $_POST['txt_cep'];
    $matricula = rand();
    $dataCadastro = date('Y-m-d');
    
    if($_POST['btnSalvar'] == "Inserir"){
                
      //Script que busca um resultado compatível com o estado escolhido
      $sqlProcuraEstado = "SELECT * FROM tbl_estado WHERE sigla = '".$txtEstado."';";

      //Executa o script no BD
      $selectProcuraEstado = mysqli_query($conexao, $sqlProcuraEstado);

      //Armazenando o id do estado escolhido
      $id_estado = null;
      if($estado = mysqli_fetch_assoc($selectProcuraEstado)){
        $id_estado = $estado['id_estado'];
      }
      
      //Criando novo endereço e inserindo
      $sqlCriaEndereco = "INSERT INTO tbl_endereco(logradouro, numero, cidade, id_estado, cep) 
        VALUES('" .$txtLogradouro. "','" .$txtNumero. "',
              '" .$txtCidade. "'," .$id_estado. ",'".$txtCep."');";
      
      //Executa o script no BD
      mysqli_query($conexao, $sqlCriaEndereco);
              
      //Criado o endereço, deve-se descobrir o ID que foi criado automaticamente
      $sqlProcuraEndereco = "SELECT * FROM tbl_endereco WHERE cep ='".$txtCep."' AND  numero = '".$txtNumero."';";

      //Executa o script no BD
      $selectProcuraEndereco = mysqli_query($conexao, $sqlProcuraEndereco);

      //Armazenando o id do endereço criado
      $id_endereco = null;
      if($endereco = mysqli_fetch_assoc($selectProcuraEndereco)){
        $id_endereco = $endereco['id_endereco'];
      }  
      
      //Busca por um proprietário que tenha o CPF digitado
      $sqlProcuraProprietario = "SELECT * FROM tbl_proprietario WHERE cpf_proprietario = '".$txtCpf."' AND data_exclusao_proprietario IS NULL;";
      
      //Execução do Script no Banco
      $selectProcuraProprietario = mysqli_query($conexao, $sqlProcuraProprietario);
      
      //Armazenando o id do proprietário
      $id_proprietario = null;
      if($proprietario = mysqli_fetch_assoc($selectProcuraProprietario)){
        $id_proprietario = $proprietario['id_proprietario'];
        
        //Com o id do endereço, pode-se criar um imóvel
        $sql = "INSERT INTO tbl_imovel(matricula, id_endereco_imovel, tipo, id_proprietario, data_cadastro_imovel) 
        VALUES('" .$matricula. "'," .$id_endereco. ",
              '" .$txtTipoImovel. "'," .$id_proprietario. ", '".$dataCadastro."');";
      }else{
        echo("
            <script>
              alert('CPF não cadastrado. Por gentileza, cadastre o CPF do proprietário antes de cadastrar um imóvel.');
              window.location.href='../formulario_imovel.php';
            </script>
        ");
      }
      
    }elseif($_POST['btnSalvar'] == "Atualizar"){
      
      //Script que busca um resultado compatível com o estado escolhido
      $sqlProcuraEstado = "SELECT * FROM tbl_estado WHERE sigla = '".$txtEstado."';";

      //Executa o script no BD
      $selectProcuraEstado = mysqli_query($conexao, $sqlProcuraEstado);

      //Armazenando o id do estado escolhido
      $id_estado = null;
      if($estado = mysqli_fetch_assoc($selectProcuraEstado)){
        $id_estado = $estado['id_estado'];
      }
      
      $sqlAtualizarEndereco = "UPDATE tbl_endereco SET 
        logradouro = '" .$txtLogradouro. "',
        numero = '" .$txtNumero. "', 
        cidade = '" .$txtCidade. "',
        id_estado = " .$id_estado. ",
        cep = '" .$txtCep. "' WHERE id_endereco = " .$_SESSION['id_endereco'];
      
      //Atualizando endereço, caso tenha alterado algo
      mysqli_query($conexao, $sqlAtualizarEndereco);
      
      //Atualizando imóvel
      $sql = "UPDATE tbl_imovel SET 
        tipo ='" .$txtTipoImovel. "',
        id_endereco_imovel = ".$_SESSION['id_endereco']." WHERE id_imovel = ". $_SESSION['id_imovel'];
      
    }
    
  }
  
  //Executa um script no BD
  if(mysqli_query($conexao,$sql)){
    //Permite  redirecionar para uma página
    header('location:../formulario_imovel.php');
  }else{
    echo("Erro: Problema na execução do script no BD");
  }

  

?>