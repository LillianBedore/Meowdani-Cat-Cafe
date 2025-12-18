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
        <section class="menu-grid">
<?php
// Simulated Menu Dataset with Prices and Descriptions
$menuItems = [
    "Catpuccinos & Lattes" => [
        ["name" => "Classic Latte", "price" => "$4.50", "note" => "Espresso with steamed milk. Meow-approved."],
        ["name" => "Vanilla Catpuccino", "price" => "$5.00", "note" => "Foamy, sweet, and perfect for cat-watching."],
        ["name" => "Strawberry Matcha Meow Latte", "price" => "$5.25", "note" => "Creamy matcha with a soft green hue."],
    ],
    "Tea & Cool Drinks" => [
        ["name" => "Chamomile Nap Time Tea", "price" => "$3.75", "note" => "Relaxing herbal tea for slow afternoons."],
        ["name" => "Iced Pink Paw Lemonade", "price" => "$4.25", "note" => "Lemonade with a hint of berry and fizz."],
        ["name" => "Sparkling Catnip Spritz", "price" => "$4.50", "note" => "Minty, bubbly, and refreshing."],
    ],
    "Snacks & Treats" => [
        ["name" => "Paw Print Cookie", "price" => "$2.50", "note" => "Sugar cookie with a chocolate paw design."],
        ["name" => "Kitty Corner Brownie", "price" => "$3.00", "note" => "Rich chocolate brownie with a fudge swirl."],
        ["name" => "Mini Cheese Paw-sant", "price" => "$3.25", "note" => "Flaky crescent with a cheesy center."],
    ],
];

// Retrieve search query
$query = isset($_GET['query']) ? htmlspecialchars($_GET['query']) : null;

// Function to display menu items
function displayMenuCategories($menuItems, $query = null)
{
    foreach ($menuItems as $category => $items) {
        // Check if the category has any items that match the query (if there's a search)
        $filteredItems = array_filter($items, function ($item) use ($query) {
            return !$query || 
                   stripos($item['name'], $query) !== false || 
                   stripos($item['note'], $query) !== false;
        });

        if (!empty($filteredItems)) {
            echo "<article class='menu-card'>";
            echo "<h3 class='menu-section-title'>$category</h3>";

            foreach ($filteredItems as $item) {
                echo "<div class='menu-item'>
                        <span class='menu-item-name'>{$item['name']}</span>
                        <span class='menu-item-price'>{$item['price']}</span>
                      </div>
                      <p class='menu-item-note'>{$item['note']}</p>";
            }

            echo "</article>";
        }
    }
}

// HTML structure for menu page
?>
    </section>
    </main>
    <footer class="site-footer">
    <p>© 2025 Meowdani Cat Cafe. Made with love and cat hair.</p>
    </footer>
    </body>
</html>