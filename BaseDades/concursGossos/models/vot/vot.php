<?php

class vot
{
    public $sessio;
    public $fase;
    public $gos;

    public function __construct($sessio, $fase, $gos){
        $this -> sessio = $sessio;
        $this -> fase = $fase;
        $this -> gos = $gos;
    }

   

}

?>