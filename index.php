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
    <div id="recipes"></div>

    <!-- search bar-->
    <div class="search-bar">
        <input type="text" id="search-input" placeholder="Search...">
        <button id="search-button">search</button>
    </div>


    <script>
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
                const recipeCard = `
                    <div class="recipe-card" data-id="${recipe.id}">
                        <h2>${recipe.title}</h2>
                        <p>${recipe.description}</p>
                        <a href="view-recipe.php?id=${recipe.id}">View Recipe</a>
                        <button class="delete-button" data-id="${recipe.id}">Delete</button>
                    </div>
                `;
                recipesDiv.innerHTML += recipeCard;
            });

            // Attach event listeners to delete buttons
            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', function () {
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
        //add even listener to search button
        document.getElementById('search-button').addEventListener('click', () => {
            const query = document.getElementById('search-input').value.trim();
            console.log('Search query:', query); // Log the query
            fetchRecipes(query);
        })
        // Optionally, refresh recipes periodically
        // setInterval(fetchRecipes, 10000); // Fetch recipes every 10 seconds
    </script>

</body>

</html>