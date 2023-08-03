<?php
require("../app/data_validator.php");
require("../app/database_driver.php");
require("../app/passwordEncryptor.php");
require("../app/user_access_updater.php");
require("../app/response_sender.php");
require("../app/request_handler.php");


$responseObject = new stdClass();
$responseObject->status = "failed";


if (request_handler::postMethodHasError("email", "password")) {
    $responseObject->error = "invalid request";
    response_sender::sendJson($responseObject);
}



//gather inputs
$email = trim($_POST['email']);
$password = trim($_POST['password']);


//validate inputs
if (empty($email) || empty($password)) {
    $responseObject->error = "empty input values";
    response_sender::sendJson($responseObject);
}

$validateReadyObject = (object) [
    'email' => [
        (object) ['datakey' => 'email', 'value' => $email],
    ],
];

$dataValidator = new data_validator($validateReadyObject);
$validationErrors = $dataValidator->validate();
foreach ($validationErrors as $key => $value) {
    if ($value) {
        $responseObject->error = "email ias not correct format";
        response_sender::sendJson($responseObject);
    }
}





//gather data from database
$database_driver = new database_driver();
$query = "SELECT `password_hash`, `password_salt`,`UID` FROM `user` WHERE email = ?";
$stmt = $database_driver->execute_query($query, 's', [$email]);

// Bind variables to the result
$stmt->bind_result($passwordHash, $passwordSalt, $userid);

// Fetch the result
$stmt->fetch();

if (empty($userid)) {
    $responseObject->error = "email not match to database";
    response_sender::sendJson($responseObject);
}



//check acess by comparing
if (!PasswordHashVerifier::isValid($password, $passwordSalt, $passwordHash)) {
    $responseObject->error = "incorrect password";
    response_sender::sendJson($responseObject);
};


//create a session
$UseerAccess = new UseerAccess();
$UseerAccess->login($userid);




//send response
$responseObject->status = "success";
response_sender::sendJson($responseObject);
