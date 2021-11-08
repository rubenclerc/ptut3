<?php

/**
 * 
 */
class Compte {
    private string $username;

    private string $password;

    private bool $estAdmin;

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