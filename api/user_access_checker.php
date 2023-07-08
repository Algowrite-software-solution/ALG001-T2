<?php
require("../app/data_validator.php");
require("../app/database_driver.php");
require("../app/passwordEncryptor.php");
require("../app/user_access_updater.php");
require("../app/response_sender.php");

$useerAccess = new UseerAccess();
$response = new response_sender();

if (isset($_GET['email'], $_GET['password'])) {
    $email = $_GET['email'];
    $password = $_GET['password'];

    $data = [
        "email" => [
            (object) [
                "datakey" => "email",
                "value" => $email
            ]
        ]
    ];

    $validator = new data_validator($data);
    $errors = $validator->validate();

    if ($errors->email) {
        $response->sendJson("incorrect");
    } else {
        $database = new database_driver();
        $userExists = $database->query("SELECT * FROM user WHERE email='$email'")->num_rows;

        if ($userExists) {
            $user = $database->query("SELECT * FROM user WHERE email='$email'")->fetch_assoc();
            $hash = $user['password_hash'];
            $salt = $user['salt'];

            if (PasswordHashVerifier::isValid($password, $salt, $hash)) {
                $useerAccess->login($user['UID']);
                $response->sendJson("success");
            } else {
                $response->sendJson("incorrect");
            }
        } else {
            $response->sendJson("incorrect");
        }
    }
} else {
    $response->sendJson("incorrect");
}


?>
