<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Register – Meowdani Cat Cafe</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Arvo:wght@400;700&family=Rock+Salt&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="styles.css">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>

    <!-- header/nav -->
    <header class="main-header">
        <div class="logo-title">
            <h1 class="site-title">Meowdani</h1>
            <p class="site-tagline">Cat Cafe</p>
        </div>

        <nav class="main-nav">
            <a href="index.html">Home</a>
            <a href="book.html">Meet Your Purrfect Cat</a>
            <a href="game.html">Game Center</a>
            <a href="menu.html">Menu</a>
            <a href="merch.html">Merch</a>
        </nav>

        <a href="#auth-section" class="btn btn-outline login-top">Login</a>
    </header>

    <main class="auth-page-container">
        <section class="auth-section" id="auth-section">
            <h2 class="section-title">Register</h2>
            <p class="section-intro">Welcome to your Meowdani account, start booking right meow!</p>

            <div class="auth-result">

<?php

/*database + table creation*/

//Tries to either open the previously existing customers.db database OR creates a new one if the database doesn't exist.
try {
    $path = "/home/dd3552/databases";  //!!!change the netID to what y'alls are!!!
    $db = new SQLite3($path . '/customers.db'); 
    //echo "<p>Connected to database.</p>";
} catch (Exception $e) {
    exit("<p>Error connecting to database: " . $e->getMessage() . "</p>");
}

//Creates a string that'll be inserted into a command to create a table titled "accounts" in customers.db if it doesn't already exists
$sqlCreate = "
CREATE TABLE IF NOT EXISTS accounts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL,
    password TEXT NOT NULL
);
";

try {
    $db->exec($sqlCreate); //tries to execute table creation string in database
} catch (Exception $e) {
    exit("<p>Error creating table: " . $e->getMessage() . "</p>");
}

/*getting user input/values from form*/

$name = $_POST['reg-name'];
$email = $_POST['reg-email'];
$password = $_POST['reg-password'];

/*seeing if the account is already in the database*/

// Check if email already exists
$check = $db->prepare("SELECT * FROM accounts WHERE email = :email");
$check->bindValue(':email', $email, SQLITE3_TEXT);

$result   = $check->execute(); 
$existing = $result->fetchArray(SQLITE3_ASSOC); //result obj produces an array OR false

if ($existing) {
    echo "<p><strong>An account with that email already exists.</strong></p>";
    echo "<p><a href='index.html#auth-section'>Return to registration</a></p>";
    exit(); //exits program if the array exists/theres an account w this email
}


/* insert the new account after checking they dont alr exist */

//prepare string + bind values into db table
$insert = $db->prepare("INSERT INTO accounts (name, email, password) VALUES (:name, :email, :password)");
$insert->bindValue(':name', $name, SQLITE3_TEXT);
$insert->bindValue(':email', $email, SQLITE3_TEXT);
$insert->bindValue(':password', $password, SQLITE3_TEXT);

try {
    $insert->execute(); //if you can impose values successfully into the table
    //echo "<p><strong>Registration successful!</strong></p>";
    echo "<p>Hello, <strong>$name</strong> — your account has been created.</p>";
    echo "<p><a href='index.html#auth-section'>Log in now</a></p>";
} catch (Exception $e) {
    echo "<p>Error inserting data: " . $e->getMessage() . "</p>";
}

$db->close(); //close database + save info
?>

            </div>

            <p class="auth-alt-link">
                Already have an account?
                <a href="index.html#auth-section"> Log in here!</a>
            </p>

            <div class="auth-actions">
                <a href="index.html" class="btn btn-primary">Back to Home</a>
            </div>
        </section>
    </main>

    <footer class="site-footer">
        <p>© 2025 Meowdani Cat Cafe. Made with love and cat hair.</p>
    </footer>

</body>
</html>
