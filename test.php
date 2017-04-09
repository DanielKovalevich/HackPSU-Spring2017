
<?php

require('php/capitalApi.php');

$test = new capitalApi;

$fun = $test->getUserAccounts();

print_r($fun);
