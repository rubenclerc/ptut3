<?php

namespace syrecords;


/**
 * Rsa
 */
class Rsa
{    
    /**
     * _config
     *
     * @var array
     */
    private $_config = [
        'public_key' => '',
        'private_key' => '',
    ];
    
    /**
     * __construct
     *
     * @param  string $private_key_filepath
     * @param  string $public_key_filepath
     * @return Rsa
     */
    public function __construct($private_key_filepath, $public_key_filepath) {
        $this->_config['private_key'] = $this->_getContents($private_key_filepath);
        $this->_config['public_key'] = $this->_getContents($public_key_filepath);
    }

    
    /**
     * _getContents
     *
     * @param  string $file_path
     * @return string|false
     */
    private function _getContents($file_path) {
        file_exists($file_path) or die ('Le chemin de fichier de la clé ou de la clé publique est erroné');
        return file_get_contents($file_path);
    }

    
    /**
     * _getPrivateKey
     *
     * @return bool|resource
     */
    private function _getPrivateKey() {
        $priv_key = $this->_config['private_key'];
        return openssl_pkey_get_private($priv_key);
    }

    
    /**
     * _getPublicKey
     *
     * @return bool|resource
     */
    private function _getPublicKey() {
        $public_key = $this->_config['public_key'];
        return openssl_pkey_get_public($public_key);
    }

    
    /**
     * privEncrypt
     *
     * @param string $data
     * @return null|string
     */
    public function privEncrypt(string $data = '') {
        if (!is_string($data)) {
            return null;
        }
        return openssl_private_encrypt($data, $encrypted, $this->_getPrivateKey()) ? base64_encode($encrypted) : null;
    }

    
    /**
     * publicEncrypt
     *
     * @param  string $data
     * @return null|string
     */
    public function publicEncrypt(string $data = '') {
        if (!is_string($data)) {
            return null;
        }
        return openssl_public_encrypt($data, $encrypted, $this->_getPublicKey()) ? base64_encode($encrypted) : null;
    }

    
    /**
     * privDecrypt
     *
     * @param  string $encrypted
     * @return null
     */
    public function privDecrypt(string $encrypted = '') {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_private_decrypt(base64_decode($encrypted), $decrypted, $this->_getPrivateKey())) ? $decrypted : null;
    }

    
    /**
     * publicDecrypt
     *
     * @param  string $encrypted
     * @return null
     */
    public function publicDecrypt(string $encrypted = '') {
        if (!is_string($encrypted)) {
            return null;
        }
        return (openssl_public_decrypt(base64_decode($encrypted), $decrypted, $this->_getPublicKey())) ? $decrypted : null;
    }
}