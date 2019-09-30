<?php
  
  //Abre a conexão com banco de dados
  require_once('conexao.php');
  $conexao = conexaoMysql();

  if(isset($_GET['modo'])){
    
    if($_GET['modo'] == "excluir"){
      
      //Recebe o id enviado via URL enviado pelo link do HTML
      $codigo = $_GET['codigo'];
      
      //Busca informações de contratos vigentes
      $sqlBuscaContratos = "SELECT * FROM tbl_imovel_cliente WHERE id_imovel = ".$codigo." AND data_final IS NULL;";
      
      $selectBuscaContratos = mysqli_query($conexao, $sqlBuscaContratos);
      
      //Cria array com id de imóveis que estão associados a contratos vigentes
      while($contrato = mysqli_fetch_assoc($selectBuscaContratos)){
        $contratos[] = $contrato['id_imovel'];
      }
      
      $semContratos = true;
      
      foreach($contratos as $imovelComContrato){
        if($imovelComContrato == $codigo){
          $semContratos = false;
        }  
      }
      
      //Se o imóvel não estiver incluso em contratos vigentes, poderá ser removido
      if($semContratos){
      
        //Definindo data de remoção do imóvel
        $dataExclusao = date('Y-m-d');
      
        //Script para atualizar a data de remoção de um imóvel no banco
        $sql = "UPDATE tbl_imovel SET data_exclusao_imovel = '".$dataExclusao."' WHERE id_imovel =".$codigo;

        //Executa o script no BD
        if(mysqli_query($conexao, $sql)){

          header('location: ../formulario_imovel.php');  

        }else{

          echo("Erro ao excluir registro de proprietário.");

        }  
        
      }else{
        echo("
            <script>
              
              alert('Este imóvel possui contratos vigentes e não poderá ser excluído.');
              window.location.href='../formulario_imovel.php';
            
            </script>
        ");
      }
      
      
    }
    
  }

?>