<?php
// include 'db.php';
include '../config/db.php';

session_start(); // Start session

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

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
            <!-- Recipes will be displayed here -->
        </div>
    </div>

    <script>
        function deleteRecipe(recipeId) {
            if (!confirm('Are you sure you want to delete this recipe?')) return;

            fetch('delete-recipe.php', {
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


        // Function to fetch recipes (with or without search query)
        function fetchRecipes(query = '') {
            fetch(`ajax-fetch-recipes.php?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    const recipesDiv = document.getElementById('recipes');
                    recipesDiv.innerHTML = ''; // Clear existing recipes
                    if (data.length === 0) {
                        recipesDiv.innerHTML = '<p>No recipes found.</p>';
                        return;
                    }
                    data.forEach(recipe => {
                        const deleteButton = `<?php if ($role === 'admin') { ?> 
                    <button class="btn btn-danger btn-sm delete-button" data-id="${recipe.id}">Delete</button> 
                    <?php } ?>`;

                        const recipeCard = `
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">${recipe.title}</h5>
                                <p class="card-text">${recipe.description}</p>
                                <a href="view-recipe.php?id=${recipe.id}" class="btn btn-primary">View Recipe</a>
                                ${deleteButton}
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
                    });<?php
                    session_start();
                    
                    // Check if user is logged in before fetching recipes
                    if (!isset($_SESSION['username'])) {
                        header("Location: login.php");
                        exit();
                    }
                    
                    function fetchRecipes(string $query = ''): void {
                        // Your code for fetching recipes
                    }
                    
                    // Rest of your code
                    ?><?php
                    session_start();
                    
                    // Validate and sanitize the query parameter
                    $query = isset($_GET['query']) ? filter_var($_GET['query'], FILTER_SANITIZE_STRING) : '';
                    
                    // Use prepared statement to prevent SQL injection
                    $stmt = $conn->prepare("SELECT * FROM recipes WHERE title LIKE ? OR ingredients LIKE ? ORDER BY id DESC");
                    $searchTerm = '%' . $query . '%';
                    $stmt->bind_param("ss", $searchTerm, $searchTerm);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    
                    // Rest of your code
                    ?><?php
                    session_start();
                    
                    // Validate and sanitize input parameters
                    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
                    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
                    $ingredients = filter_input(INPUT_POST, 'ingredients', FILTER_SANITIZE_STRING);
                    $steps = filter_input(INPUT_POST, 'steps', FILTER_SANITIZE_STRING);
                    
                    // Use prepared statement to prevent SQL injection
                    $stmt = $conn->prepare("INSERT INTO recipes (title, description, ingredients, steps) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $title, $description, $ingredients, $steps);
                    $stmt->execute();
                    
                    // Rest of your code
                    ?><?php
                    session_start();
                    
                    // Check if user is an admin before approving or rejecting requests
                    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
                        header("Location: login.php");
                        exit();
                    }
                    
                    function approveRequest(int $id): void {
                        // Your code for approving a request
                    }
                    
                    function rejectRequest(int $id): void {
                        // Your code for rejecting a request
                    }
                    
                    // Rest of your code
                    ?>
                })
                .catch(error => console.error('Error fetching recipes:', error));
        }
    </script>
</body>

</html>     