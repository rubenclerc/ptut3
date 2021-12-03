<?php

class BadUserError extends Exception
{


    public function __construct()
    {
        $this->message = "Cet utilisateur n'existe pas";
    }

    
    public function __toString(): string{
        return $this->message;
    }

}
?>