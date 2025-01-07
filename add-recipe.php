<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Add Recipe</h1>
    <form id="add-recipe-form">
        <label for="title">Title:</label>
        <input type="text" name="title" placeholder="Enter recipe title" required>

        <label for="description">Description:</label>
        <textarea name="description" placeholder="Enter a brief description of the recipe" required></textarea>

        <label for="ingredients">Ingredients (separated by commas):</label>
        <textarea name="ingredients" placeholder="e.g., sugar, flour, eggs" required></textarea>

        <label for="steps">Steps (separated by commas):</label>
        <textarea name="steps" placeholder="e.g., mix ingredients, bake at 350°F" required></textarea>

        <button type="submit">Add Recipe</button>
    </form>
    <div id="response-message"> </div>

    <script>
        document.getElementById('add-recipe-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission
            const form = document.getElementById('add-recipe-form');
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const title = form.querySelector('input[name="title"]').value.trim();
                if (!title) {
                    alert('Title is required.');
                    return;
                }
                // Proceed with the fetch call...
            });

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
                        this.reset(); // Clear the form
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