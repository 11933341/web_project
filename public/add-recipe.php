<?php
// include 'db.php'; 
include '../config/db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>
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

    <div class="container mt-5">
        <h1 class="text-center mb-4">Add Recipe</h1>
        <form id="add-recipe-form" class="card p-4">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" placeholder="Enter recipe title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" placeholder="Enter a brief description of the recipe" required></textarea>
            </div>
            <div class="mb-3">
                <label for="ingredients" class="form-label">Ingredients</label>
                <textarea class="form-control" name="ingredients" placeholder="e.g., sugar, flour, eggs" required></textarea>
            </div>
            <div class="mb-3">
                <label for="steps" class="form-label">Steps</label>
                <textarea class="form-control" name="steps" placeholder="e.g., mix ingredients, bake at 350°F" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Add Recipe</button>
        </form>
        <div id="response-message" class="mt-3"></div>
    </div>

    <script>
        document.getElementById('add-recipe-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('ajax-add-recipe.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    const messageDiv = document.getElementById('response-message');
                    if (data.success) {
                        messageDiv.textContent = data.message;
                        messageDiv.style.color = 'green';
                        this.reset();
                    } else {
                        messageDiv.textContent = data.message;
                        messageDiv.style.color = 'red';
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</body>

</html>