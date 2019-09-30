<?php
  
  //Abre a conexão com banco de dados
  require_once('conexao.php');
  $conexao = conexaoMysql();

  if(isset($_GET['modo'])){
    
    if($_GET['modo'] == "excluir"){
      
      //Recebe o id enviado via URL enviado pelo link do HTML
      $codigo = $_GET['codigo'];
      
      //Realiza a busca de dados de imóveis disponíveis no momento
      $sqlBuscaImoveis = "SELECT * FROM tbl_imovel WHERE id_proprietario = ".$codigo." AND data_exclusao_imovel IS NULL;";
      
      $selectBuscaImoveis = mysqli_query($conexao, $sqlBuscaImoveis);
      
      //Cria array de ids de proprietários com imóveis disponíveis
      while($proprietario = mysqli_fetch_assoc($selectBuscaImoveis)){
        $proprietariosComImoveis[] = $proprietario['id_proprietario'];
      }
      
      $semImoveis = true;
      
      foreach($proprietariosComImoveis as $proprietario){
        if($proprietario == $codigo){
          $semImoveis = false;
        }  
      }
      
      //Se o proprietário não tiver imóveis disponíveis, poderá ser removido
      if($semImoveis){
        
        //Definindo data de remoção do proprietário
        $dataExclusao = date("Y-m-d");
        
        //Script para atualizar a data de saída de um proprietário do banco
        $sql = "UPDATE tbl_proprietario SET data_exclusao_proprietario = '".$dataExclusao."' WHERE id_proprietario =".$codigo;

        //Executa o script no BD
        if(mysqli_query($conexao, $sql)){
          header('location: ../formulario_proprietario.php');  
        }else{
          echo("Erro ao excluir registro de proprietário.");
        }
        
      }else{
        echo("
            <script>
              
              alert('Este proprietário possui imóveis disponíveis para contrato no momento e não pode ser excluído. Exclua suas propriedades para que possa ser excluído.');
              window.location.href='../formulario_proprietario.php';
            
            </script>
        ");
      }
      
    }
    
  }

?>