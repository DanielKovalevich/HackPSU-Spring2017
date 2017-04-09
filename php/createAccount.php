<?php

require('capitalApi.php');

if(!isset($_SESSION['nickname']) || !isset($_SESSION['accounttype'])) {

	print("Missing some data. How did you get here?");
}

else {

	$api = new capitalApi;

	//Soon™

}