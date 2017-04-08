<?php

    include("curl.php");
    $curl = new Curl;

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        header("Location: /invest_dashboard.php");
        exit();
    }
    else if ($_SERVER["REQUEST_METHOD"] == "POST") {

    }

?>