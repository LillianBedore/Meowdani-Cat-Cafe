<!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF-8">
    <title>Search Results – Meowdani Cat Cafe</title>

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

    <a href="menu.html" class="btn btn-outline login-top">Back to Menu</a>
</header>

<main class="auth-page-container">
<?php echo "<h1 class='results-section-title'>Search Results</h1>"; ?>
<section class="results-grid">

<?php
$menu = [
    "Catpuccinos & Lattes" => [
        "Classic Latte" => [
            "price" => "$4.50",
            "description" => "Espresso with steamed milk. Meow-approved."
        ],
        "Vanilla Catpuccino" => [
            "price" => "$5.00",
            "description" => "Foamy, sweet, and perfect for cat-watching."
        ],
        "Strawberry Matcha Meow Latte" => [
            "price" => "$5.25",
            "description" => "Creamy matcha with a soft green hue."
        ]
    ],

    "Tea & Cool Drinks" => [
        "Chamomile Nap Time Tea" => [
            "price" => "$3.75",
            "description" => "Relaxing herbal tea for slow afternoons."
        ],
        "Iced Pink Paw Lemonade" => [
            "price" => "$4.25",
            "description" => "Lemonade with a hint of berry and fizz."
        ],
        "Sparkling Catnip Spritz" => [
            "price" => "$4.50",
            "description" => "Minty, bubbly, and refreshing."
        ]
    ],

    "Snacks & Treats" => [
        "Paw Print Cookie" => [
            "price" => "$2.50",
            "description" => "Sugar cookie with a chocolate paw design."
        ],
        "Kitty Corner Brownie" => [
            "price" => "$3.00",
            "description" => "Rich chocolate brownie with a fudge swirl."
        ],
        "Mini Cheese Paw-sant" => [
            "price" => "$3.25",
            "description" => "Flaky crescent with a cheesy center."
        ]
    ]
];

if (isset($_GET['query'])) {
    $query = strtolower(trim($_GET['query']));
    $results = [];

    echo "<p1 class='results-query'> You searched for: $query.</p1>";
    echo "<a id='results-home-btn' class='btn btn-outline' href='index.html'>Return to Home</a>";

    foreach ($menu as $sectionTitle => $items) {

        // If section title matches → include all items
        if (stripos($sectionTitle, $query) !== false) {
            foreach ($items as $itemName => $details) {
                $results[$itemName] = $details;
            }
            continue;
        }

        // Otherwise search individual items
        foreach ($items as $itemName => $details) {
            if (
                stripos($itemName, $query) !== false ||
                stripos($details['description'], $query) !== false
            ) {
                $results[$itemName] = $details;
            }
        }
    }

    if (!empty($results)) {
        foreach ($results as $itemName => $details) {
            echo "
            <article class='results-card'>
                <div class='results-item'>
                    <span class='results-item-name'>".htmlspecialchars($itemName)."</span>
                    <span class='results-item-price'>" . htmlspecialchars($details['price']) . "</span>
                </div>
                <p class='results-item-note'>" . htmlspecialchars($details['description']) . "</p>
            </article>
            ";
        }
    } else {
        echo "<p class='results-card'>No menu items matched your search. Try different keywords!</p>";
    }
} else {
    echo "<p class='results-card'>Please enter a search term.</p>";
}
?>

</section>
</main>

<footer class="site-footer">
    <p>© 2025 Meowdani Cat Cafe. Made with love and cat hair.</p>
</footer>

</body>
</html>
