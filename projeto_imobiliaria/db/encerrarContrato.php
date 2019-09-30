<?php
  
  //Abre a conexão com banco de dados
  require_once('conexao.php');
  $conexao = conexaoMysql();

  if(isset($_GET['modo'])){
    
    if($_GET['modo'] == "excluir"){
      
      //Recebe o id enviado via URL enviado pelo link do HTML
      $codigo = $_GET['codigo'];
      
      $dataFinal = date("Y-m-d");
      
      //Script para deletar registro no banco de dados
      $sql = "UPDATE tbl_imovel_cliente SET data_final = '".$dataFinal."' WHERE cod_contrato =".$codigo;
      
      //Executa o script no BD
      if(mysqli_query($conexao, $sql)){
        header('location: ../formulario_contrato.php');
      }else{
        echo("Erro ao excluir registro.");   
      }
      
    }
    
  }

?>