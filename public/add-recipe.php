<?php
include '../config/db.php';
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
?>
<?php include 'navbar.php'; ?>

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
