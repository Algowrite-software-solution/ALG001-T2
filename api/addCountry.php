<?php


require("../app/dbQuery.php");

$countryArray = json_decode(file_get_contents("countries.json"));

$db = new DB();


foreach ($countryArray as $value) {
    $db->prepare("INSERT INTO `country`(`country_name`, `country_code`) VALUES (?, ?)", "ss", [$value->name, $value->code]);
    echo $value->name . "<br>";
}

echo "success";
