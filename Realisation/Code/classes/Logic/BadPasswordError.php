<?php

class BadPasswordError extends Exception
{
    private $options;

    public function __construct(string $options)
    {
        $this->options = $options;
        $this->message = "Mauvais mot de passe";
    }

    
    public function __toString(): string{
        return $this->message . " : " . $this->options;
    }

}
?>