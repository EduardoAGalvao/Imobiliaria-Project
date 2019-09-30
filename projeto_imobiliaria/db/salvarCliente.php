<?php
  
  //Declaração das variáveis
  $txtNome = (string) null;
  $txtCpf = (string) null;
  $txtIdade = (string) null;
  $txtTelefone = (string) null;
  
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
    $txtIdade = $_POST['txt_idade'];
    $txtTelefone = $_POST['txt_telefone'];
    $dataCadastro = date("Y-m-d");
    
    if($_POST['btnSalvar'] == "Inserir"){
      
      $sql = "INSERT INTO tbl_cliente(nome_cliente, cpf_cliente, idade, telefone_cliente, data_cadastro_cliente) 
        VALUES('" .$txtNome. "','" .$txtCpf. "',
              '" .$txtIdade. "','" .$txtTelefone. "', '".$dataCadastro."');";  
      
    }elseif($_POST['btnSalvar'] == "Atualizar"){
      
      $sql = "UPDATE tbl_cliente SET 
        nome_cliente ='" .$txtNome. "',
        cpf_cliente = '" .$txtCpf. "',
        idade = '" .$txtIdade. "',
        telefone_cliente = '" .$txtTelefone. "' WHERE id_cliente = ". $_SESSION['id'];
      
    }
    
  }
  
  //Executa um script no BD
  if(mysqli_query($conexao,$sql)){
    //Permite  redirecionar para uma página
    header('location:../formulario_cliente.php');
  }else{
    echo("Erro: Problema na execução do script no BD");
    echo $sql;
  }

  

?>