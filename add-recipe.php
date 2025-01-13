<?php
include 'db.php';
session_start();

// Restrict access to the page
if (!isset($_SESSION['role'])) {
    die("Access denied: Login required.");
}

// Check user role
$isAdmin = $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Recipe</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1><?php echo $isAdmin ? 'Add Recipe' : 'Request Recipe'; ?></h1>
    <form id="add-recipe-form">
        <label for="title">Title:</label>
        <input type="text" name="title" placeholder="Enter recipe title" required>

        <label for="description">Description:</label>
        <textarea name="description" placeholder="Enter a brief description of the recipe" required></textarea>

        <label for="ingredients">Ingredients (separated by commas):</label>
        <textarea name="ingredients" placeholder="e.g., sugar, flour, eggs" required></textarea>

        <label for="steps">Steps (separated by commas):</label>
        <textarea name="steps" placeholder="e.g., mix ingredients, bake at 350°F" required></textarea>

        <button type="submit"><?php echo $isAdmin ? 'Add Recipe' : 'Submit Request'; ?></button>
    </form>
    <div id="response-message"></div>

    <script>
        document.getElementById('add-recipe-form').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            const formData = new FormData(this);

            fetch('<?php echo $isAdmin ? "ajax-add-recipe.php" : "ajax-add-request.php"; ?>', {
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