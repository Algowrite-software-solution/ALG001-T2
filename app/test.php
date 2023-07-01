<?php

require("data_validator.php");

$inputData = trim('{"id_int":[{"datakey":"data1","value":"12423"},{"datakey":"data2","value":"12423"},{"datakey":"data3","value":"janith"}],"email":[{"datakey":"myEmail","value":"rmjanithnirmal@gmail.com"},{"datakey":"yourEmail","value":"not an email"}]}');

$object = json_decode($inputData);

$validator = new data_validator($object);
$errors = $validator->validate();

echo var_dump($errors);
