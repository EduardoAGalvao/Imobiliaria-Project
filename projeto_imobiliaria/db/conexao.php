<?php

function conexaoMysql(){

  /*Conexão com BD Mysql*/
  define("SERVER", "localhost"); //Local onde o BD está instalado
  define("USER", "root"); //Usuário do BD
  define("PASSWORD", ""); //Senha para uso em casa
  define("DATABASE", "db_imobiliaria");

  $conexao = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
  
  return $conexao;

}

?>