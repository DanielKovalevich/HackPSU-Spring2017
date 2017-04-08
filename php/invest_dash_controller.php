<?php
    require '/../vendor/autoload.php';
    include("php/connection.php");

    use GuzzleHttp\Client;

    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $client = new Client(['base_uri' => 'api.reimaginebanking.com']);
        $array = $client->request('GET', 'accounts?key=f88bb319eadd8f435028df201925f4d');
        $sql = "SELECT uid FROM WHERE username = " . $_SESSION["username"] . "";

        $id = $db->query($sql);

        $array = json_decode($array);

        foreach($element as $array) {
            print($element);
        }
    }

?>