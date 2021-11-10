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
    public function __construct(){
        
    }


    /**
     * 
     */
    public function seConnecter(){
        
    }
    /**
     * 
     */
    public function seDeconnecter(){

    }
    /**
     * 
     */
    public function getEstAdmin() : bool{
        return $this->estAdmin;
    }
}
?>