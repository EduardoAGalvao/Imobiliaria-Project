"use strict";

$(document).ready(function(){
  
  
    //Visualização dos tipos de imóveis existentes
    $('#slt_tipo_imovel').on('change', function() {
      
      let $tipo_imovel = this.value;
      
      switch($tipo_imovel){
        case "casa":
          $('.imovel_apartamento').css('display', 'none');
          $('.imovel_casa').css('display', 'block');
          break;
          
        case "apartamento":
          $('.imovel_apartamento').css('display', 'block');
          $('.imovel_casa').css('display', 'none');
          break;
          
        default:
          $('.imovel_apartamento').css('display', 'block');
          $('.imovel_casa').css('display', 'block');
          break;
      }
      
    });
  
  //Setando evento para limpar URL caso queira cancelar a edição
  const $botaoLimpar = $('.botaoLimpar');
  
  $botaoLimpar.click(function () {
        if($botaoLimpar.val() == "Cancelar"){
          
          //window.location.pathname ignora os atributos GET na URL, retornando 
          //para o caminho original
          window.location.href = window.location.pathname;
  
        }
    });
  
});