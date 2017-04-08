<?php
// Daniel Kovalevich
// To make curl statements easier

class Curl{
    private $json_array = "";
    private $url = "";

    public function setURL($url) {
        $this->$url = $url;
    }

    public function get() {
        $curl = curl_init();
        $this->$json_array = curl_setopt($curl, CURLOPT_URL, $url);
        curl_exec($curl);
        curl_close($curl);

        return json_decode($json_array);
    }
}


?>