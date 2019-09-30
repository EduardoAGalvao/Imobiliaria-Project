<?php
  
  //Declaração das variáveis
  $txtNome = (string) null;
  $txtCpf = (string) null;
  $txtDataNascimento = (string) null;
  $txtTelefone = (string) null;
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
    
    $txtNome = $_POST['txt_nome'];
    $txtCpf = $_POST['txt_cpf'];
    
    $txtDataNascimento = explode("/",$_POST['txt_nascimento']);
    $txtDataNascimento = $txtDataNascimento[2]."-".$txtDataNascimento[1]."-".$txtDataNascimento[0];
    $dataCadastro = date("Y-m-d");
    
    $txtTelefone = $_POST['txt_telefone'];
    $txtLogradouro = $_POST['txt_logradouro'];
    $txtNumero = $_POST['txt_numero'];
    $txtCidade = $_POST['txt_cidade'];
    $txtEstado = $_POST['slt_estado'];
    $txtCep = $_POST['txt_cep'];
    
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
      
      //Com o id do endereço, pode-se criar um proprietário
      $sql = "INSERT INTO tbl_proprietario(nome_proprietario, cpf_proprietario, telefone_proprietario, data_nascimento, id_endereco, data_cadastro_proprietario) 
        VALUES('" .$txtNome. "','" .$txtCpf. "',
              '" .$txtTelefone. "','" .$txtDataNascimento. "',".$id_endereco.",'".$dataCadastro."');";  
      
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
        
      $sql = "UPDATE tbl_proprietario SET 
        nome_proprietario ='" .$txtNome. "',
        cpf_proprietario = '" .$txtCpf. "',
        telefone_proprietario = '" .$txtTelefone. "',
        data_nascimento = '" .$txtDataNascimento. "',
        id_endereco = ".$_SESSION['id_endereco']." WHERE id_proprietario = ". $_SESSION['id_proprietario'];
      
    }
    
  }
  
  //Executa um script no BD
  if(mysqli_query($conexao,$sql)){
    //Permite  redirecionar para uma página
    header('location:../formulario_proprietario.php');
  }else{
    echo("Erro: Problema na execução do script no BD");
  }

  

?>