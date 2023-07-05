<?php
require("database_driver.php"); // file navigation is important 




$database = new database_driver();
$searchQuery = "INSERT INTO tablename (column1, column2, column3) VALUES (?, ?, ?);";//this is sql query insert,update or delete
$stmt1 = $database->execute_query($searchQuery, "sss", array('data1', 'data2', 'data3'));
