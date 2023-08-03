<?php

require("../app/database_driver.php");
require("../app/data_validator.php");
require("../app/password_encrypter");
require("../app/user_access_updater.php");
require("../app/response_sender.php");

// incoming request verification and validation
$request=$_POST["registor_data"];
$requestObject=jason_decode($request);

$email=$requestObject->email;
$userName=$requestObject->username;
$displayName=$requestObject->displayName;
$password=$requestObject->password;
$rePassword=$requestObject->rePassword;
$birthdate=$requestObject->birthdate;

// user access check


// gather inputs and validate inputs

// api process

// api response