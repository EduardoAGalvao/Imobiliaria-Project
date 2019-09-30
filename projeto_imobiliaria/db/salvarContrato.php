<?php
  
  //Declaração das variáveis
  $txtCpf = (string) null;
  $txtImovel = (string) null;
  
  //Inicializando $_SESSION
  session_start();
  
  //Validação para receber dados do form via POST
  if(isset($_POST['btnSalvar'])){
    
    //Importa o arquivo de conexão com BD
    require_once('conexao.php');
    
    //Abre a conexão com BD
    $conexao = conexaoMysql();
    
    //Obtendo informações necessárias para o fechamento do contrato
    $txtCpf = $_POST['txt_cpf'];
    $txtImovel = $_POST['rdo_imovel'];
    $codContrato = rand();
    $dataInicio = date("Y-m-d");
    
    if($_POST['btnSalvar'] == "Inserir"){
                
      //Script que busca um resultado compatível com o CPF do cliente digitado
      $sqlProcuraCliente = "SELECT * FROM tbl_cliente WHERE cpf_cliente = '".$txtCpf."' AND data_exclusao_cliente IS NULL;";

      //Executa o script no BD
      $selectProcuraCliente = mysqli_query($conexao, $sqlProcuraCliente);

      $id_cliente = null;
      if($cliente = mysqli_fetch_assoc($selectProcuraCliente)){
        
        //Armazenando o id do cliente de acordo com o CPF
        $id_cliente = $cliente['id_cliente'];
        
        $sql = "INSERT INTO tbl_imovel_cliente(id_cliente, id_imovel, cod_contrato, data_inicio) VALUES (".$id_cliente.",".$txtImovel.",
        '".$codContrato."', '".$dataInicio."');";

      }else{

        echo("
            <script>
              alert('CPF não cadastrado. Por gentileza, cadastre o CPF do cliente antes de firmar um contrato.');
              window.location.href='../formulario_contrato.php';
            </script>
        ");

      }
      
    }
    
  }
  
  //Executa um script no BD
  if(mysqli_query($conexao,$sql)){
    //Permite  redirecionar para uma página
    header('location:../formulario_contrato.php');  
  }else{
    echo("Erro: Problema na execução do script no BD");
  }

?>