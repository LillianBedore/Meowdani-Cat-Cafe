<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book a Cat</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Arvo:wght@400;700&family=Rock+Salt&display=swap" rel="stylesheet">

<link rel="stylesheet" href="styles.css">
</head>

<body>

<header class="main-header">
  <div class="logo-title">
    <h1 class="site-title">Meowdani</h1>
    <p class="site-tagline">Cat Cafe</p>
  </div>

  <nav class="main-nav">
    <a href="index.html">Home</a>
    <a href="book.html">Meet Your Perfect Cat</a>
    <a href="game.html">Game Center</a>
    <a href="menu.html">Menu</a>
    <a href="merch.html">Merch</a>
  </nav>

  <a href="index.html#auth-section" class="btn btn-outline login-top">Login</a>
</header>

<main id="main-content">

<section class="page-hero">
<?php
//get values
$name     = $_POST['name'] ?? '';
$email    = $_POST['email'] ?? '';
$datetime = $_POST['date-time'] ?? '';
$cats     = $_POST['cats'] ?? [];
$total    = $_POST['total'] ?? '0.00';

if (!$name || !$email || !$datetime) { //if user didnt fill smthn out
    exit("<p>Missing required information.</p>");
}

$catList = empty($cats) ? "None" : implode(", ", $cats); //check if u booked w a cat, append strings if u booked w multiple

try {
    $path = "/home/dd3552/databases";//CHANGE TO YOUR OWN NETID for i6 Y'ALL 
    $db = new SQLite3($path . "/customers.db");
} catch (Exception $e) {
    exit("<p>Database connection failed.</p>");
}

/*create accounts table if doesnt exist alr */
$db->exec("
CREATE TABLE IF NOT EXISTS accounts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    email TEXT UNIQUE,
    password TEXT,
    booking_datetime TEXT,
    booked_cats TEXT,
    total_paid REAL
)
");

/* ================================
   RULE 1: user can only book once
================================ */
$checkUser = $db->prepare("
    SELECT 1 FROM accounts
    WHERE email = :email
    AND booking_datetime IS NOT NULL
");
$checkUser->bindValue(":email", $email, SQLITE3_TEXT);

if ($checkUser->execute()->fetchArray()) {
    exit("<p><strong>You have already booked a visit.</strong></p>");
}

/* ==========================================
   RULE 2: no two people can book same cat/time
========================================== */
foreach ($cats as $cat) {
    $checkCat = $db->prepare("
        SELECT 1 FROM accounts
        WHERE booking_datetime = :dt
        AND booked_cats LIKE :cat
    ");
    $checkCat->bindValue(":dt", $datetime, SQLITE3_TEXT);
    $checkCat->bindValue(":cat", "%" . $cat . "%", SQLITE3_TEXT);

    if ($checkCat->execute()->fetchArray()) {
        exit("<p><strong>$cat is already booked for this time.</strong></p>");
    }
}

/*update user or create a new one*/
$existing = $db->prepare("
    SELECT id FROM accounts WHERE email = :email
");
$existing->bindValue(":email", $email, SQLITE3_TEXT);
$exists = $existing->execute()->fetchArray();

if ($exists) {

    $update = $db->prepare("
        UPDATE accounts
        SET booking_datetime = :dt,
            booked_cats = :cats,
            total_paid = :total
        WHERE email = :email
    ");

    $update->bindValue(":dt", $datetime, SQLITE3_TEXT);
    $update->bindValue(":cats", $catList, SQLITE3_TEXT);
    $update->bindValue(":total", $total, SQLITE3_FLOAT);
    $update->bindValue(":email", $email, SQLITE3_TEXT);
    $update->execute();

} else {

    $insert = $db->prepare("
        INSERT INTO accounts
        (name, email, booking_datetime, booked_cats, total_paid)
        VALUES (:name, :email, :dt, :cats, :total)
    ");

    $insert->bindValue(":name", $name, SQLITE3_TEXT);
    $insert->bindValue(":email", $email, SQLITE3_TEXT);
    $insert->bindValue(":dt", $datetime, SQLITE3_TEXT);
    $insert->bindValue(":cats", $catList, SQLITE3_TEXT);
    $insert->bindValue(":total", $total, SQLITE3_FLOAT);
    $insert->execute();
}

$db->close();
?>

<!-- Receipt Output -->
<h1><strong>Booking Confirmed!</strong></h1>
<p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
<p><strong>Email:</strong> <?= htmlspecialchars($email) ?></p>
<p><strong>Date & Time:</strong> <?= htmlspecialchars($datetime) ?></p>
<p><strong>Cats Booked:</strong> <?= htmlspecialchars($catList) ?></p>
<p><strong>Total Charged:</strong> $<?= htmlspecialchars($total) ?></p>

</section>
</main>
</body>
</html>
