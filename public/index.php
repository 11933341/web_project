<?php
include 'navbar.php';
include '../config/db.php';
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Get the user's role
$role = $_SESSION['role'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Sharing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Recipe Sharing</h1>
        <div class="text-center mb-4">
            <?php if ($role === 'admin') { ?>
                <a href="add-recipe.php" class="btn btn-primary">Add Recipe</a>
                <a href="manage-users.php" class="btn btn-secondary">Manage Users</a>
            <?php } ?>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <div class="row">
            <div class="col-12">
                <input type="text" id="search-input" class="form-control mb-3" placeholder="Search...">
                <button id="search-button" class="btn btn-outline-primary w-100">Search</button>
            </div>
        </div>
        <div id="recipes" class="row gy-3">
            <!-- Recipes will be dynamically displayed here -->
        </div>
    </div>

    <script>
        // Function to fetch recipes
        function fetchRecipes(query = '') {
            fetch(`ajax-fetch-recipes.php?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    const recipesDiv = document.getElementById('recipes');
                    recipesDiv.innerHTML = ''; // Clear existing recipes
                    if (data.length === 0) {
                        recipesDiv.innerHTML = '<p class="text-center">No recipes found.</p>';
                        return;
                    }
                    data.forEach(recipe => {
                        const recipeCard = `
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">${recipe.title}</h5>
                                        <p class="card-text">${recipe.description}</p>
                                        <a href="view-recipe.php?id=${recipe.id}" class="btn btn-primary">View Recipe</a>
                                        <?php if ($role === 'admin') { ?>
                                            <button class="btn btn-danger delete-button" data-id="${recipe.id}">Delete</button>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        `;
                        recipesDiv.innerHTML += recipeCard;
                    });

                    // Add event listeners to delete buttons
                    document.querySelectorAll('.delete-button').forEach(button => {
                        button.addEventListener('click', function() {
                            const recipeId = this.getAttribute('data-id');
                            deleteRecipe(recipeId);
                        });
                    });
                })
                .catch(error => console.error('Error fetching recipes:', error));
        }

        // Function to delete a recipe
        function deleteRecipe(recipeId) {
            if (!confirm('Are you sure you want to delete this recipe?')) return;

            fetch(`delete-recipe.php`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: recipeId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Recipe deleted successfully!');
                        fetchRecipes(); // Refresh the recipe list
                    } else {
                        alert('Error deleting recipe: ' + data.message);
                    }
                })
                .catch(error => console.error('Error deleting recipe:', error));
        }

        // Fetch recipes on page load
        fetchRecipes();

        // Add event listener to search button
        document.getElementById('search-button').addEventListener('click', () => {
            const query = document.getElementById('search-input').value.trim();
            fetchRecipes(query);
        });
    </script>
</body>

</html>
