<?php
include '../config/db.php';
session_start();

if (!isset($_SESSION['username']) || $_SESSION['role'] === 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];

    $stmt = $conn->prepare("INSERT INTO recipe_requests (title, description, ingredients, steps, user_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $title, $description, $ingredients, $steps, $_SESSION['user_id']);

    if ($stmt->execute()) {
        $successMessage = "Your recipe request has been sent!";
    } else {
        $errorMessage = "Error sending request: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Recipe Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Send Recipe Request</h1>
        <form method="POST" class="card p-4">
            <?php if (isset($successMessage)) { ?>
                <div class="alert alert-success"><?php echo $successMessage; ?></div>
            <?php } ?>
            <?php if (isset($errorMessage)) { ?>
                <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
            <?php } ?>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="ingredients" class="form-label">Ingredients</label>
                <textarea class="form-control" name="ingredients" required></textarea>
            </div>
            <div class="mb-3">
                <label for="steps" class="form-label">Steps</label>
                <textarea class="form-control" name="steps" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Request</button>
        </form>
    </div>
</body>

</html>
