<?php
require("../app/dbdriver.php"); // file navigation is important 
$database = new DB();
// insert data into MySQL database
$searchQuery = "INSERT INTO test1 (name, age, gender) VALUES (?, ?, ?);";
$stmt1 = $database->execute_query($searchQuery, "sss", array('kaviska', '12', 'male'));


// incoming request verification and validation

// user access check

// gather inputs and validate inputs

// api process

// api response