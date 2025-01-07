<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Sharing</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Recipe Sharing</h1>
    <div class="add-recipe-link">
        <a href="add-recipe.php">Add Recipe</a>
    </div>
    <div id="recipes">
        <?php
        $sql = "SELECT * FROM recipes";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='recipe-card'>
                        <h2>{$row['title']}</h2>
                        <p>{$row['description']}</p>
                        <a href='view-recipe.php?id={$row['id']}'>View Recipe</a>
                      </div>";
            }
        } else {
            echo "<p>No recipes found.</p>";
        }
        ?>
    </div>
</body>
</html>
