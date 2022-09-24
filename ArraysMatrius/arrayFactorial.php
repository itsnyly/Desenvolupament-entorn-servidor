<?php

function factorialArray($arr, $fn){
    $arr2 = []; // moved the array formation out of the for loop so it doesn't get overwritten
    if(is_array($arr)){
        for($i = 0; $i < sizeof($arr); $i++){ // starting $i at 0
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

$factorial = function($value) use (&$factorial){ // note the reference to the lambda function $userDefined
   if(1 == $value) {
       return 1;
   } 
   else {
       return $value * $factorial($value - 1); // here is the recursion which performs the factorial math
   }
};

$arr = [1,2,3,4,5];
$newArray = factorialArray($arr, $factorial);
print_r($newArray);

?>