<?php 
// include 'db.php';
include '../config/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Recipe</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="recipe-details">
        <?php
        $id = $_GET['id'];
        $sql = "SELECT * FROM recipes WHERE id=$id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            echo "<h1>{$row['title']}</h1>";
            echo "<p>{$row['description']}</p>";
            echo "<h2>Ingredients</h2><p>{$row['ingredients']}</p>";
            echo "<h2>Steps</h2><p>{$row['steps']}</p>";
        } else {
            echo "<p>Recipe not found.</p>";
        }
        ?>
    </div>
</body>
</html>
