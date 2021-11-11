<?php

/**
 * 
 */
class Compte {
    private string $username;

    private string $password;

    private bool $estAdmin;
    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(string $username, string $password, bool $estAdmin){
        $this->username = $username;
        $this->password = $password;
        $this->estAdmin = $estAdmin;
    }
    /**
     * 
     */
    public function getEstAdmin() : bool{
        return $this->estAdmin;
    }
}
?>