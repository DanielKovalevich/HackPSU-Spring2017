<?php

    include("curl.php");
    $curl = new Curl;

    header("Location: http://104.236.109.78/invest_dashboard.php");
    exit();

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        header("Location: http://104.236.109.78/invest_dashboard.php");
        exit();
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST") {

    }

?>