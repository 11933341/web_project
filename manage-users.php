<?php
session_start();
include 'db.php';

// Restrict access to admins only
if ($_SESSION['role'] !== 'admin') {
    die("Access denied: Admins only.");
}

// Handle promotion to admin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];

    // Update the user's role to admin
    $stmt = $conn->prepare("UPDATE users SET role = 'admin' WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        $successMessage = "User promoted to admin successfully.";
    } else {
        $errorMessage = "Error promoting user: " . $stmt->error;
    }
}

// Fetch all users
$result = $conn->query("SELECT id, username, role FROM users ORDER BY role DESC, username ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Manage Users</h1>

    <?php if (isset($successMessage)) echo "<p style='color: green;'>$successMessage</p>"; ?>
    <?php if (isset($errorMessage)) echo "<p style='color: red;'>$errorMessage</p>"; ?>

    <table border="1" style="width: 50%; margin: auto; text-align: center;">
        <thead>
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td>
                        <?php if ($user['role'] === 'member') { ?>
                            <form method="POST" action="manage-users.php" style="display: inline;">
                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                <button type="submit">Promote to Admin</button>
                            </form>
                        <?php } else { ?>
                            <span>Admin</span>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
