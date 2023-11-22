<?php
function usuarioOk($usuario, $contraseña): bool //devuelve true si la contraseña es el nombre a la inversa
{
   $contraseña_valida = strrev($usuario);//invierte el string

   if ($contraseña == $contraseña_valida) {
      return true;
   } else {
      return false;
   }
}

function contarPalabras($frase)//devuelve la cantidad de palabras que tiene el string
{

   $cantidad_palabras = str_word_count($frase, 0); //devuelve cantidad de palabras encontradas

   return $cantidad_palabras;
}

function letraRepetida($frase): string //devuelve la letra que mas se repite sin contar espacios
{

   $letras_sueltas = str_split($frase);
   $conteo_letras = [];

   foreach ($letras_sueltas as $clave => $valor) {

      if ($valor != " ") {

         if (array_key_exists($valor, $conteo_letras)) {
            $conteo_letras[$valor]++;
         } else {
            $conteo_letras[$valor] = 1;
         }
      }
   }
   $letra = "";
   $repeticiones_letra = "0";

   foreach ($conteo_letras as $clave => $valor) {

      if ($repeticiones_letra < $valor) {
         $letra = $clave;
         $repeticiones_letra = $valor;
      }
   }

   return $letra;
}


function palabraRepetida($frase): string //devuelve la palabra que mas se repite
{
   $lista_palabras = str_word_count($frase, 1);
   $conteo_palabras = [];
   foreach ($lista_palabras as $valor) {

      if (array_key_exists($valor, $conteo_palabras)) {
         $conteo_palabras[$valor]++;
      } else {
         $conteo_palabras[$valor] = 1;
      }
   }

   $palabra = "";
   $repeticiones_palabra = "0";

   foreach ($conteo_palabras as $clave => $valor) {

      if ($repeticiones_palabra < $valor) {
         $palabra = $clave;
         $repeticiones_palabra = $valor;
      }
   }

   return $palabra;
}
