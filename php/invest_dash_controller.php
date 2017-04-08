<?php
    include_once("/php/curl.php");
    $curl = new Curl;

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        header("Location: http://104.236.109.78/invest_dashboard.php");
        exit();
    }

?>