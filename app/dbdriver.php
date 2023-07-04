<?php
class DB
{
    private $host;
    private $user;
    private $password;
    private $database;
    private $connection;

    // Constructor that takes in connection details and establishes a connection to the database
    public function __construct()
    {
        $host = 'localhost';
        $user = 'root';

        $password = 'KaviskaDilshan12#$'; // malidu
        //$password = 'JanithNirmal12#$'; // janith
        $database = 'test';

        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;


        // Connect to the database using mysqli
        $this->connection = new mysqli($host, $user, $password, $database);

        // Check for any connection errors
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function insert($tablename, $coloumname = [], $types, $params)
{
    $valuecount = count($coloumname);

    // Prepare the statement using mysqli
    $stmt = $this->connection->prepare("INSERT INTO $tablename (".implode(", ", $coloumname).") VALUES (".str_repeat('?, ', $valuecount - 1) . '?)');

    if (!$stmt) {
        die("Prepare failed: " . $this->connection->error);
    }

    // Bind the parameters to the statement using mysqli
    $bindResult = $stmt->bind_param($types, ...$params);

    if (!$bindResult) {
        die("Binding parameters failed: " . $stmt->error);
    }

    // Execute the statement
    $executeResult = $stmt->execute();

    if (!$executeResult) {
        die("Execution failed: " . $stmt->error);
    }

    // Return the statement object
    return $stmt;
}


public function update($tablename, $set, $where, $types, $params)
{
    // Prepare the statement using mysqli
    $stmt = $this->connection->prepare("UPDATE $tablename SET $set WHERE $where");

    if (!$stmt) {
        die("Prepare failed: " . $this->connection->error);
    }

    // Bind the parameters to the statement using mysqli
    $bindResult = $stmt->bind_param($types, ...$params);

    if (!$bindResult) {
        die("Binding parameters failed: " . $stmt->error);
    }

    // Execute the statement
    $executeResult = $stmt->execute();

    if (!$executeResult) {
        die("Execution failed: " . $stmt->error);
    }

    // Return the statement object
    return $stmt;
}

public function delete($tablename, $where, $types, $params)
{
    // Prepare the statement using mysqli
    $stmt = $this->connection->prepare("DELETE FROM $tablename WHERE $where");

    if (!$stmt) {
        die("Prepare failed: " . $this->connection->error);
    }

    // Bind the parameters to the statement using mysqli
    $bindResult = $stmt->bind_param($types, ...$params);

    if (!$bindResult) {
        die("Binding parameters failed: " . $stmt->error);
    }

    // Execute the statement
    $executeResult = $stmt->execute();

    if (!$executeResult) {
        die("Execution failed: " . $stmt->error);
    }

    // Return the statement object
    return $stmt;
}

   
    // Destructor that closes the database connection
    public function __destruct()
    {
        // Close the database connection using mysqli
        $this->connection->close();
    }
}
