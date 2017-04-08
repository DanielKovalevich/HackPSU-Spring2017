
<?php
    include("connection.php");
    
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        // $sql = "SELECT uid FROM WHERE username = " . $_SESSION["username"] . "";
       // $id = $db->query($sql);
        $url = "http://api.reimaginebanking.com/accounts?key=f88bb319eadd8f435028df201925f4d2";
        
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        
        
        $json = curl_exec($ch);
        
        
        print("hello");
        
        print_r($json);
        
        header("Location: http://104.236.109.78/invest_dashboard.php");
        exit();

    }
        $curl_close($ch);

?>