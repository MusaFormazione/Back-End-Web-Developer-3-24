<?php
session_start();

// Get PDO connection from db_connection.php
$pdo = require_once 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sakila Actors</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Sakila Database - Actors</h1>
    
    <?php
    // Display success message if set
    if (isset($_SESSION['success_message'])) {
        echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']);
    }
    
    // Display error message if set
    if (isset($_SESSION['error_message'])) {
        echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']);
    }
    
    try {
        // Prepare and execute query to get actors
        $stmt = $pdo->prepare("SELECT actor_id, first_name, last_name, last_update FROM actor ORDER BY last_name, first_name LIMIT 50");
        $stmt->execute();
        
        // Check if we have results
        if ($stmt->rowCount() > 0) {
            echo '<table>';
            echo '<tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Last Update</th><th>Actions</th></tr>';
            
            // Output data of each row
            while ($row = $stmt->fetch()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['actor_id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['first_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['last_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['last_update']) . '</td>';
                echo '<td class="action-links">';
                echo '<a href="edit_actor.php?id=' . $row['actor_id'] . '">Edit</a>';
                echo '</td>';
                echo '</tr>';
            }
            
            echo '</table>';
        } else {
            echo '<p>No actors found in the database.</p>';
        }
    } catch (PDOException $e) {
        echo '<p>Error: ' . $e->getMessage() . '</p>';
    }
    ?>
    
    <p><a href="index.php">Back to Home</a></p>
</body>
</html>