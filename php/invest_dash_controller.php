
<?php
    require '../vendor/autoload.php';
    include("php/connection.php");
    use GuzzleHttp\Client;

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $client = new Client(['base_uri' => 'api.reimaginebanking.com']);
        $array = $client->get("http://api.reimaginebanking.com/accounts?key=f88bb319eadd8f435028df201925f4d2");
        // $sql = "SELECT uid FROM WHERE username = " . $_SESSION["username"] . "";
       // $id = $db->query($sql);
       // $array = json_decode($array);


        $array = json_decode($array->getBody());
        $array = $array[0];
        print_r($array);

        header("Location: http://104.236.109.78/invest_dashboard.php");
        exit();
    }

?>
