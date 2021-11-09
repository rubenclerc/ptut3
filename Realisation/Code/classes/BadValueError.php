<?php

class BadValueError extends Exception
{

    public function __construct()
    {
        $this->message = "Erreur de valeur: ";
    }

    
    public function __toString(): string{
        return $this->message;
    }

}