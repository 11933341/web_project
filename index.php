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

    <script>
        function fetchRecipes() {
            fetch('ajax-fetch-recipes.php')
                .then(response => response.json())
                .then(data => {
                    const recipesDiv = document.getElementById('recipes');
                    recipesDiv.innerHTML = ''; // Clear existing recipes
                    data.forEach(recipe => {
                        const recipeCard = `
                            <div class="recipe-card">
                                <h2>${recipe.title}</h2>
                                <p>${recipe.description}</p>
                                <a href="view-recipe.php?id=${recipe.id}">View Recipe</a>
                            </div>
                        `;
                        recipesDiv.innerHTML += recipeCard;
                    });
                })
                .catch(error => console.error('Error fetching recipes:', error));
        }

        // Fetch recipes on page load
        fetchRecipes();

        // Optionally, refresh recipes periodically
        setInterval(fetchRecipes, 10000); // Fetch recipes every 10 seconds
    </script>

</body>

</html>