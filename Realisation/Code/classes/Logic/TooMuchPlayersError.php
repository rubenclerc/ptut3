<?php

class TooMuchPlayersError extends BadValueError
{


    public function __construct()
    {
        $this->message = "Le challenge est déjà rempli.";
    }

    
    public function __toString(): string{
        return parent::__toString() . $this->message;
    }

}
?>