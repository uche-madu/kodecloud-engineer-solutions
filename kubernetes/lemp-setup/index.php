<?php
// Fetch MySQL configuration from environment variables
$dbname = getenv('MYSQL_DATABASE');
$dbuser = getenv('MYSQL_USER');
$dbpass = getenv('MYSQL_PASSWORD');
$dbhost = getenv('MYSQL_HOST');

// Create a database connection
$connect = mysqli_connect($dbhost, $dbuser, $dbpass) or die("Unable to Connect to '$dbhost'");

// Check the connection and select the database
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the database exists
if (!mysqli_select_db($connect, $dbname)) {
    die("Database '$dbname' does not exist.");
}

echo "Connected successfully to the database '$dbname'";
?>