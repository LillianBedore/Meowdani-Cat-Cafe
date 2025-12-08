<!DOCTYPE HTML>
<head>
  <link rel="stylesheet" href="styles.css" />
</head>
<body>
<?php
// use try block to catch and report errors when creating the db

try {
    // Open a connection to the SQLite database
    // If the users.db doesn't exist, it will be created.

    // Use these 2 line when you run the php  live on i6 server  (the following two lines)
    //!!!!!NOTE: we have to change the path to corresspond to our own directories when uploading to i6
    $path= "/home/lrb9212/databases";
    $db = new SQLite3($path. '/users.db' );


    //Comment the above code if you are testing the code for local server code ( the line after these comments)

    // use this statemnt if testing from local server (and remove //). This will create a local users.db isnide the same folder as program
    //     $db = new SQLite3($path. '/users.db' );

    // report a message if all went fine for testing purposes
    echo "Successfully connected to the users.db <br>";
} 

    // report the error if we couldnt open the test2.db  for testing purposes

    catch (Exception $e) {
    echo "Error connecting to the database: " . $e->getMessage() . "<br>";

    exit();
}


// create a table inside the test2.db; 
//you can create as many tables as you need - for example you can create two tables for your final project: products and users



// construct a create table (called users) query; if exists then igonre
$sqlCreateTable = " CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        password TEXT  NOT NULL
    );
";

// execute the line of code to create the table within try block to cath errors assoicated with executing this statemenet 

try {
    $db->exec($sqlCreateTable);
    echo "Table 'users' created successfully or already exists.<br>";
} 

// catch the errors associated with excuting the above statement


catch (Exception $e) {
    echo "Error creating table: " . $e->getMessage() . "<br>";
}

// get values from form to insert inside the users table
$name = $_POST['reg-name'];
$email = $_POST['reg-email'];
$password = $_POST['reg-password'];

echo "<p> $name: $email: $password (only for testing purposes)<p>";


// construct an insert query to store values inside table
$sqlInsert = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";


// use try block to construct an insert query  to store values into users.db

try {

    $stmt = $db->prepare($sqlInsert);
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->bindValue(':password', $password, SQLITE3_TEXT);
    
    // execute the statement 
    $stmt->execute();
    echo " Info inserted: $name and $email and $password values inserted successfully.<br>";


} 

// catch and report errors associated with executing above statements
catch (Exception $e) {
    echo "Error inserting data: " . $e->getMessage() . "<br>";
}


// if we are done with the database we should close it
// this allows Apache to use it again quickly, rather than waiting for
// the database's natural timeout to occur

$db->close();
unset($db);


echo "Database connection closed.<br>";
?>

</body>
</html>
