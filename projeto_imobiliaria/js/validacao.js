"use strict";

$(document).ready(function(){
    
    //Declaração de variáveis de campos
    const $textos = document.querySelectorAll(".texto");
    const $numeros = document.querySelectorAll(".numero");
    const $cpf = document.querySelectorAll(".cpf");
    const $telefones = document.querySelectorAll(".telefone");
    const $alfanumericos = document.querySelectorAll(".alfanumerico");
    const $cep = document.querySelectorAll(".cep");
    const $dataNascimento = document.querySelectorAll(".data_nascimento");
  
    //Máscara para texto
    function filtrarTexto(txt) {
      return txt.replace(/[^A-Za-zÀ-ÿ ]/g, "");
    };
  
    //Máscara para alfanumérico
    function filtrarAlfanumerico(txt) {
      return txt.replace(/[^A-Za-zÀ-ÿ0-9 ]/g, "");
    };
  
    //Máscara para números
    function filtrarNumero(txt) {
      return txt.replace(/[^0-9]/g, "");
    };
  
    //Máscara para CPF
    function mascaraCpf(texto) {
      return filtrarNumero(texto).replace(/(.{3})/, "$1.")
                                 .replace(/(.{7})(.)/, "$1.$2")
                                 .replace(/(.{11})(.)/, "$1-$2");
    };
  
    //Máscara para telefone
    function mascaraTelefone(texto) {
        return filtrarNumero(texto).replace(/(.)/, "($1")
                                   .replace(/(.{3})(.)/, "$1)$2")
                                   .replace(/(.{8})(.)/, "$1-$2");
    };
  
    //Máscara para CEP
    function mascaraCep(texto) {
        return filtrarNumero(texto).replace(/(.{5})(.)/, "$1-$2");
    };
  
    //Máscara para Data 
    function mascaraData(texto) {
        return filtrarNumero(texto).replace(/(.{2})(.)/, "$1/$2")
                                   .replace(/(.{5})(.)/, "$1/$2");
    };
  
    for(let texto of $textos){
      texto.addEventListener("keyup", function () {
        return texto.value = filtrarTexto(texto.value);
      });  
    }
  
    for(let cpf of $cpf){
      cpf.addEventListener("keyup", function () {
        return cpf.value = mascaraCpf(cpf.value);
      }); 
    }
  
    for(let numero of $numeros){
      numero.addEventListener("keyup", function(){
        return numero.value = filtrarNumero(numero.value);
      });
    }
  
    for(let telefone of $telefones){
      telefone.addEventListener("keyup", function(){
        return telefone.value = mascaraTelefone(telefone.value);
      });
    }
  
    for(let alfanumerico of $alfanumericos){
      alfanumerico.addEventListener("keyup", function(){
        return alfanumerico.value = filtrarAlfanumerico(alfanumerico.value);
      });
    }
  
    for(let cep of $cep){
      cep.addEventListener("keyup", function(){
        return cep.value = mascaraCep(cep.value);
      });
    }
  
    for(let dataNascimento of $dataNascimento){
      dataNascimento.addEventListener("keyup", function(){
        return dataNascimento.value = mascaraData(dataNascimento.value);
      });
    }
  
});
  
    
   