<?php
// Daniel Kovalevich
// To make curl statements easier

class Curl{
    private $json_array = "";
    private $url = "";

    function __construct($url) {
        $this->$url = $url;
    }

    public function get() {
        $curl = curl_init();
        if ($this->$json_array = curl_setopt($curl, $url, 1)) {
            curl_exec($curl);
            curl_close($curl);

            return json_decode($json_array);
        }
        else 
            return false;
    }

    public function post() {
            
    }


}


?>