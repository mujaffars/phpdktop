<?php

class Encdec
{
    protected $encryptMethod = 'AES-256-CBC';
    
    public function getKey(){
        $CI=& get_instance();
        return $CI->config->item('key');
    }
    public function decrypt($encryptedString,$ivParam = NULL)
    {
        
        $key = $this->getKey();
        if($ivParam){
             $iv = '2UjTvhimQyASk3==';
            $salt = NULL;
            $iterations = 999;
            $cipherText = base64_decode($encryptedString);
        }else{
           $json = json_decode(base64_decode($encryptedString), true);
            try {
                $salt = hex2bin($json["salt"]);
                $iv = hex2bin($json["iv"]);
            } catch (Exception $e) {
                return null;
            }
            $cipherText = base64_decode($json['ciphertext']);
            $iterations = intval(abs($json['iterations']));
            if ($iterations <= 0) {
                $iterations = 999;
            }  
        }

        $hashKey = hash_pbkdf2('sha512', $key, $salt, $iterations, ($this->encryptMethodLength() / 4));
        unset($iterations, $json, $salt);
        $decrypted= openssl_decrypt($cipherText , $this->encryptMethod, hex2bin($hashKey), OPENSSL_RAW_DATA, $iv);
        unset($cipherText, $hashKey, $iv);
        return $decrypted;
    }

    public function encrypt($string,$ivParam = NULL)
    {
        
        $key = $this->getKey();

        if($ivParam){
            $iv = '2UjTvhimQyASk3==';
            $salt = NULL;
        }else{
            $ivLength = openssl_cipher_iv_length($this->encryptMethod);
            $iv = openssl_random_pseudo_bytes($ivLength);
            $salt = openssl_random_pseudo_bytes(256); 
        }
        
        $iterations = 999;
        $hashKey = hash_pbkdf2('sha512', $key, $salt, $iterations, ($this->encryptMethodLength() / 4));
        $encryptedString = openssl_encrypt($string, $this->encryptMethod, hex2bin($hashKey), OPENSSL_RAW_DATA, $iv);
        $encryptedString = base64_encode($encryptedString);
        unset($hashKey);
        $output = ['ciphertext' => $encryptedString, 'iv' => bin2hex($iv), 'salt' => bin2hex($salt), 'iterations' => $iterations];
        if($ivParam){
            unset($iterations, $iv, $ivLength, $salt);
            return $encryptedString;
        }else{
            unset($encryptedString, $iterations, $iv, $ivLength, $salt);
            return base64_encode(json_encode($output));
        }
    }


    protected function encryptMethodLength()
    {
        $number = filter_var($this->encryptMethod, FILTER_SANITIZE_NUMBER_INT);
        return intval(abs($number));
    }
    
    public function setCipherMethod($cipherMethod)
    {
        $this->encryptMethod = $cipherMethod;
    }// setCipherMethod
    public function loadjson(){
        $ci=&get_instance();
        $inputData = file_get_contents("php://input");
        return json_decode($inputData);

    }
    public function returnjson($data){

        return json_encode($data,JSON_NUMERIC_CHECK);
    }
}