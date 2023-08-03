<?php


require_once("../app/data_validator.php");
require_once("../app/database_driver.php");
require_once("../app/passwordEncryptor.php");
require_once("../app/request_handler.php");
require_once("../app/request_handler.php");
require_once("../app/response_sender.php");
require_once("../app/user_access_updater.php");


// response
$responseObject = new stdClass();
$responseObject->status = "failed";

// request handle
header('Content-Type: application/json');

if (request_handler::postMethodHasError("signInData")) {
    $responseObject->error = "Invalid Request";
    response_sender::sendJson($responseObject);
}
$signInDataObject = json_decode(trim($_POST["signInData"]));

if (
    !$signInDataObject
    || (!isset($signInDataObject->email) || empty($signInDataObject->email))
    || !isset($signInDataObject->username) || empty($signInDataObject->username)
    || !isset($signInDataObject->displayName) || empty($signInDataObject->email)
    || !isset($signInDataObject->password) || empty($signInDataObject->password)
    || !isset($signInDataObject->retypePassword) || empty($signInDataObject->retypePassword)
    || !isset($signInDataObject->birthday) || empty($signInDataObject->birthday)
) {
    $responseObject->error = "Invalid JSON Data";
    response_sender::sendJson($responseObject);
}





$validateReadyObject = new stdClass();
$validateReadyObject = (object) [
    'email' => [
        (object) ['datakey' => 'email', 'value' => $signInDataObject->email],
    ],
    'name' => [
        (object) ['datakey' => 'username', 'value' => $signInDataObject->username],
        (object) ['datakey' => 'displayName', 'value' => $signInDataObject->displayName],
    ],
    'password' => [
        (object) ['datakey' => 'password', 'value' => $signInDataObject->password],
        (object) ['datakey' => 'retypePassword', 'value' => $signInDataObject->retypePassword],
    ],
    'date' => [
        (object) ['datakey' => 'birthday', 'value' => $signInDataObject->birthday],
    ],
];

$validator = new data_validator($validateReadyObject);
$validaterErrors = $validator->validate();

foreach ($validaterErrors as $key => $value) {
    if ($value) {
        $responseObject->errors = $validaterErrors;
        response_sender::sendJson($responseObject);
    }
}

// collect data
$email = $signInDataObject->email;
$username = $signInDataObject->username;
$displayName = $signInDataObject->displayName;
$password = $signInDataObject->password;
$retypePassword = $signInDataObject->retypePassword;
$birthday = $signInDataObject->birthday;

// password validation
if ($password !== $retypePassword) {
    $responseObject->errors = "passwords are not matching";
    response_sender::sendJson($responseObject);
}

$userId = uniqid("ALG"); // user ID generator

// user validate
$database = new database_driver();
$userCheckQuery = "SELECT `UID`, `email`,`username` FROM `user` WHERE `UID`=?  OR `email`=? OR `username`=?";
$db_response =  $database->execute_query($userCheckQuery, "sss", array($userId, $email, $username));
$resulSet = $db_response->get_result();

if ($resulSet->num_rows) {
    $row = $resulSet->fetch_assoc();
    if ($row["email"] === $email) {
        $responseObject->errors = "User exist with Same email";
    } else if ($row["username"] === $username) {
        $responseObject->errors = "User exist with Same username";
    } else if ($row["UID"] === $userId) {
        $responseObject->errors = "Error! please try again";
    }
    response_sender::sendJson($responseObject);
}

// age validation

$birthdayDate = new DateTime($birthday);
$currentDate = new DateTime();
if (date_diff($birthdayDate, $currentDate)->y < 13) {
    $responseObject->errors = "Age has to be at lease 13 to create an account";
    response_sender::sendJson($responseObject);
}


// password hash generate
$encryptedPasswordArray =  StrongPasswordEncryptor::encryptPassword($password);

// verification code
$verificationCode = substr(uniqid(), 0, 6);

$insertQuery = "INSERT INTO `user` (`UID`, `email`, `username`, `display_name`, `password_hash`, `password_salt`, `birthday`, `verification_code`, `registered_datetime`, `states_id`) 
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";
$database->execute_query($insertQuery, "sssssssss", array($userId, $email, $username, $displayName, $encryptedPasswordArray["hash"], $encryptedPasswordArray["salt"], $birthday, $verificationCode, $currentDate->format('Y-m-d H:i:s')));


$responseObject->status = "success";
response_sender::sendJson($responseObject);
