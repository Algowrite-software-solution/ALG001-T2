
<?php
require("../app/dbQuery.php");

// Read the JSON file
$jsonData = file_get_contents('../countries.json');

// Convert the JSON data to an associative array
$data = json_decode($jsonData);


// Create a new instance of the DB class
$db = new DB();

foreach ($data as $object) {
    $names = $object->name;
    $code = $object->code;

    // Prepare the SQL statement
    $sql = "INSERT INTO country (`country_name`, `country_code`)  VALUES (?, ?)";

    // Prepare the statement and bind parameters
    $stmt = $db->prepare($sql, 'ss', [$names, $code]);

    // Check for any errors
    if (!$stmt) {
        die("Statement preparation failed: " . $db->error);
    }

    // Execute the statement
    $stmt->execute();

    

    // Close the statement
    $stmt->close();
}







