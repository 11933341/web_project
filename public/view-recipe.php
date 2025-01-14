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
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">Recipe Sharing</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['username'])): ?>
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="add-recipe.php">Add Recipe</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="manage-users.php">Manage Users</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="signup.php">Sign Up</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

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