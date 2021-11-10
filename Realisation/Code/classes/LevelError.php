<?php

class LevelError extends BadValueError
{


    public function __construct()
    {
        $this->message = "Vous n'avez pas le niveau requis.";
    }

    
    public function __toString(): string{
        return parent::__toString() . $this->message;
    }

}
?>