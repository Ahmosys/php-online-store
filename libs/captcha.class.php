<?php

/**
 * Classe interagissant avec le serveur de HCAPTCHA.
 */
class GestionCaptcha {
    
    /**
     * Fonction statique permettant de vérifier si un captcha à été résolu ou non.
     * 
     * @return boolean
     */
    public static function verifyCaptcha() {
    $data = array(
            'secret' => "0x15Ec690f37d4c6D437f6C6E62000bC037E3DFd2E",
            'response' => $_POST['h-captcha-response']
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://hcaptcha.com/siteverify");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        $responseData = json_decode($response); 
        return ($responseData->success);
    }
    
}

?>
