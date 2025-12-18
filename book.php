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
            <h2 class="section-title">Request received!</h2>
            <p class="section-intro">We're excited for your visit to Meowdani Cat Cafe!</p>
            
            <div class="auth-result">
<?php
// Get the user's input from the form
$name = $_POST['reg-name'];
$email = $_POST['reg-email'];
$datetime = $_POST['date-time'];
$cats = $_POST['cats'];
$total = $_POST['final-cost'];

echo "<p>You selected datetime: <strong>$datetime</strong></p>";

if (!$name || !$email || !$datetime) {
    echo "<p><strong>All fields are required: Name, Email, and Date/Time.</strong></p>";
    echo "<p><a href='book.html'>Try again</a></p>";
    exit();
}

try {
    // Establish the SQLite3 database connection
    $path = "/home/kar9641/databases";
    $db = new SQLite3($path . '/customers.db');
} catch (Exception $e) {
    exit("<p>Database connection failed: " . $e->getMessage() . "</p>");
}

// Create the accounts table if it does not exist
$db->exec("
CREATE TABLE IF NOT EXISTS accounts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    datetime DATETIME NOT NULL UNIQUE, -- UNIQUE constraint to prevent duplicate entries
    cats TEXT,
    total REAL
);
");

// Check if the datetime already exists in the database
$stmt = $db->prepare("SELECT * FROM accounts WHERE datetime = :datetime");
$stmt->bindValue(":datetime", $datetime, SQLITE3_TEXT);
$result = $stmt->execute();

if ($result->fetchArray(SQLITE3_ASSOC)) {
    // If a row with the same datetime exists, show an error
    echo "<p><strong>Error:</strong> The time slot <strong>$datetime</strong> is already taken. Please choose a different time.</p>";
    echo "<p><a href='book.html'>Try again</a></p>";
    $db->close();
    exit();
}

// If no conflict, insert the new user's data into the database
$stmt = $db->prepare("
    INSERT INTO accounts (name, email, datetime, cats, total)
    VALUES (:name, :email, :datetime, :cats, 0)
");
$stmt->bindValue(":name", $name, SQLITE3_TEXT);
$stmt->bindValue(":email", $email, SQLITE3_TEXT);
$stmt->bindValue(":datetime", $datetime, SQLITE3_TEXT);
$stmt->bindValue(":cats", $cats, SQLITE3_TEXT);

if ($stmt->execute()) {
    // Success message
    echo "<p><strong>Successfully registered!</strong></p>";
    echo "<p>Thank you, <strong>$name</strong>, for scheduling your appointment for <strong>$datetime</strong>.</p>";
    echo "<p><a href='index.html'>Visit homepage</a></p>";
} else {
    // If there’s an error inserting the data, show an error message
    echo "<p><strong>Error:</strong> Could not save the appointment. Please try again.</p>";
}

$db->close(); // Close the database connection
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