<!DOCTYPE HTML>
<html>
<head>
  <link rel="stylesheet" href="styles.css" />
  <meta charset="UTF-8">
  <title>Login</title>
</head>
<body>
  <div class="auth-page-container">
    <section class="auth-section">
        <h2 class="section-title">Login</h2>
        <p class="section-intro">Welcome back to Meowdani! Please log in to continue.</p>
<?php

/*get user input/values from login form*/
$email = $_POST['login-email'];
$password = $_POST['login-password'];

echo "<p>You entered email: <strong>$email</strong></p>";

if (!$email || !$password) { //double checking the user entered some email and psswd
    echo "<p><strong>Email and password are required.</strong></p>";
    echo "<p><a href='index.html#auth-section'>Try again</a></p>";
    exit(); //exiting program entirely if no email or psswd entered
}


/*trying to open database (customers.db)/creating it if it doesn't exist*/

try {
    $path = "/home/dd3552/databases"; //!!!change the HTML to what y'alls are!!!
    $db = new SQLite3($path . '/customers.db');
} catch (Exception $e) {
    exit("<p>Database connection failed: " . $e->getMessage() . "</p>");
}

/*validating that the email and password submitted match up to a row in the database*/

$stmt = $db->prepare("
    SELECT id, name, email, password
    FROM accounts
    WHERE email = :email AND password = :password
");

$stmt->bindValue(":email", $email, SQLITE3_TEXT); //bind email collected to val
$stmt->bindValue(":password", $password, SQLITE3_TEXT); //bind psswd collected to val

$result = $stmt->execute(); //attempt to execute query ONTO the database
$user   = $result->fetchArray(SQLITE3_ASSOC); //returns false or an array (aka account exists)

/*response based on if account exists or not*/

if ($user) {
    echo "<p><strong>Login successful!</strong></p>";
    echo "<p>Welcome, <strong>{$user['name']}</strong>!</p>";
    echo "<p><a href='index.html'>Visit homepage</a></p>";
} 
else {
    echo "<p><strong>Incorrect email or password.</strong></p>";
    echo "<p><a href='index.html#auth-section'>Try again</a></p>";
}

/*close database to save vals properly*/
$db->close();
?>
<p class="auth-alt-link"> Don’t have an account yet? <a href="index.html#auth-section">Create one here.</a> </p>
</section>
</div>

</body>
</html>

