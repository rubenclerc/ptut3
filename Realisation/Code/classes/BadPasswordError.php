<?php

class BadPasswordError extends Exception
{


    public function __construct()
    {
        $this->message = "Mauvais mot de passe";
    }

    
    public function __toString(): string{
        return $this->message;
    }

}