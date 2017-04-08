<?php

$test = new capitalApi;
$test->getUserAccounts("Checking");

class capitalApi {

	private function runCurlGet($url) {

		$c = curl_init();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
        $json = curl_exec($c);
        curl_close($c);

        return $json;
	}

	private function runCurlPost($url) {

		$c = curl_init();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
        $json = curl_exec($c);
        curl_close($c);

        return $json;
	}

	function getUserAccounts($parameters) {

		$url = 'http://api.reimaginebanking.com/accounts?type='.urlencode($parameters).'&key=f88bb319eadd8f435028df201925f4d2';

		print_r(json_decode($this->runCurlGet($url)));
	}
}
