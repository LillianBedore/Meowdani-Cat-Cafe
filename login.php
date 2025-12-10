<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login – Meowdani Cat Cafe</title>

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
            <h2 class="section-title">Login</h2>
            <p class="section-intro">Welcome back! Come see what new cat friends we have.</p>

            <div class="auth-result">
              
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
    //echo "<p><a href='index.html'>Visit homepage</a></p>";
} 
else {
    echo "<p><strong>Incorrect email or password.</strong></p>";
    echo "<p><a href='index.html#auth-section'>Try again</a></p>";
}

/*close database to save vals properly*/
$db->close();
?>

            </div>

            <p class="auth-alt-link">
                Need an account?
                <a href="index.html#auth-section"> Register here!</a>
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
