<?php

function mathh($arr, $fn){
    $arr2 = []; // moved the array formation out of the for loop so it doesn't get overwritten
    for($i = 0; $i < sizeof($arr); $i++){ // starting $i at 0
        $arr2[$i] = $fn($arr[$i]);
    }
    return $arr2;
}

$userDefined = function($value) use (&$userDefined){ // note the reference to the lambda function $userDefined
   if(1 == $value) {
       return 1;
   } else {
       return $value * $userDefined($value - 1); // here is the recursion which performs the factorial math
   }
};

$arr = [1,2,3,4,5];
$newArray = mathh($arr, $userDefined);
print_r($newArray);

?>