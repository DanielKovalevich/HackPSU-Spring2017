<?php
    include_once("/php/curl.php");
    include("php/connection.php");

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $curl = new Curl;
        $sql = "SELECT uid FROM WHERE username = " . $_SESSION["username"] . "";

        $id = $db->query($sql);
        $url = "api.reimaginebanking.com";

        $array = $curl->setURL($url . "accounts?key=f88bb319eadd8f435028df201925f4d2");

        foreach($element as $array) {
            print($element);
        }
    }

?>