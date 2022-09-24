<?php
/**
 * Funció principal la qual recòrrer l'array passat per paràmetres i guarda el valor factorial en un altre array.
 * * Comprova que el paràmetre sigui un array i que els valors interns d'aquest siguin correctes.
 * @param arr Array
 * @param fn Nom de la funció recursiva.
 * @return arr2 Array amb nous valors
 */
function factorialArray($arr, $fn){
    $arr2 = []; 
    if(is_array($arr)){
        for($i = 0; $i < sizeof($arr); $i++){ 
            if($arr[$i] < 0 || is_string($arr[$i])){
                return false;
            }
            else{
                $arr2[$i] = $fn($arr[$i]);
            }
            
        }
    }
    else{
        return false;
    }
    
    return $arr2;
}

/**
 * Funció que calcula el factorial del numero que rep per paràmetres
 * @param value Numero del qual es calcula el seu factorial
 * @return int Valor del factorial.
 */
$factorial = function($value) use (&$factorial){ 
   if(1 == $value) {
       return 1;
   } 
   else {
       return $value * $factorial($value - 1);
   }
};

$arr = [1,2,3,4,5];
$newArray = factorialArray($arr, $factorial);
print_r($newArray);

?>