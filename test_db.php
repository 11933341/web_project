<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>

<?php
include 'db.php';
if ($conn) {
    echo "database connection sucessful";
} else {
    echo "Data connection failed" . $conn->connect_error;
}
?>