<?php
  
  //Abre a conexão com banco de dados
  require_once('conexao.php');
  $conexao = conexaoMysql();

  if(isset($_GET['modo'])){
    
    if($_GET['modo'] == "excluir"){
      
      //Recebe o id enviado via URL enviado pelo link do HTML
      $codigo = $_GET['codigo'];
      
      //Seleciona dados de contratos vigentes
      $sqlBuscarContratos = "SELECT * FROM tbl_imovel_cliente WHERE data_final IS NULL;";
      
      $selectBuscarContratos = mysqli_query($conexao, $sqlBuscarContratos);
      
      //Cria array com todos os clientes que estão em contratos vigentes
      while($contrato = mysqli_fetch_assoc($selectBuscarContratos)){
        $clientesComContratoVigente[] = $contrato['id_cliente'];
      }
      
      $semContrato = true;
      
      foreach($clientesComContratoVigente as $cliente){
        if($cliente == $codigo){
          $semContrato = false;
        }  
      }
      
      //Somente se o cliente não estiver incluso em contrato vigente poderá ser excluído
      if($semContrato){
        
        $dataExclusao = date("Y-m-d");
        
        //Script para atualizar a remoção do cliente do banco de dados
        $sql = "UPDATE tbl_cliente SET data_exclusao_cliente ='" .$dataExclusao. "'WHERE id_cliente =".$codigo;
      
        //Executa o script no BD
        if(mysqli_query($conexao, $sql)){
          header('location: ../formulario_cliente.php');
        }else{
          echo("Erro ao excluir registro.");   
          echo($sql);
        }
                
      }else{
        
        echo("
            <script>
              
              alert('Este cliente possui um contrato vigente e não pode ser desligado. Para remove-lo, registre a rescisão do contrato e confirme junto ao cliente e proprietário.');
              window.location.href='../formulario_cliente.php';
            
            </script>
        ");
        
      }
      
      
      
    }
    
  }

?>