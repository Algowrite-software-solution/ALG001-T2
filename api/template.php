<?php
require("../app/database_driver.php");
require("../app/response_sender.php");
require("../app/passwordEncryptor.php");


$passwordData = StrongPasswordEncryptor::encryptPassword('malidunew123');
echo "Hash: " . $passwordData['hash'] . "<br>";
echo "Salt: " . $passwordData['salt'];

if (PasswordHashVerifier::isValid('malidunew123', $passwordData['salt'], $passwordData['hash'])) {
    echo "Password is valid.";
} else {
    echo "Password is invalid.";
};















/*
$database_driver = new database_driver(); {
    $email = $_GET['email'];
    $password = $_GET['password'];

    // Example data to validate
    $data = [
        'email' => [
            (object)['datakey' => 'email', 'value' => $email],
            // Add more email objects to validate
        ],
    ];

    // Create an instance of data_validator
    $validator = new data_validator($data);

    // Validate the data
    $errors = $validator->validate();


    // Check for email validation errors
    if (!empty($errors->email)) {
        echo "Email validation failed for 'email': " . $errors->email;
    } else {
        echo "Email validation passed for 'email'.";
        // Prepare the query to select the hash and salt columns based on the email
        $query1 = "SELECT password_hash FROM user WHERE email = ?";
        $query2 = "SELECT password_salt FROM user WHERE email = ?";

        // Prepare and execute the query using the provided email as a parameter
        $hash = $database_driver->execute_query($query1, 's', [$email]);
        $salt = $database_driver->execute_query($query2, 's', [$email]);

        // Verify the password
        if (PasswordHashVerifier::isValid($password, $salt, $hash)) {
            // Password is valid, perform signin actions
            echo "Signin successful!";

            $userAccess = new UseerAccess();
            $query3 = "SELECT UID FROM user WHERE email = ?";
            $UID = $database_driver->execute_query($query3, 's', [$email]);
            $userAccess->login($UID);
        } else {
            // Password is invalid
            echo "Invalid username or password.";
        }
    }
};*/