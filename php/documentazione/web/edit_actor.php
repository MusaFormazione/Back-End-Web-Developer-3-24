<?php
session_start();

// Get PDO connection from db_connection.php
$pdo = require_once 'db_connection.php';

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "Actor ID is required";
    header("Location: actors.php");
    exit;
}

$actor_id = intval($_GET['id']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    
    if (empty($first_name) || empty($last_name)) {
        $error_message = "Both first name and last name are required";
    } else {
        try {
            // Update actor information
            $stmt = $pdo->prepare("UPDATE actor SET first_name = :first_name, last_name = :last_name, last_update = NOW() WHERE actor_id = :actor_id");
            $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            $stmt->bindParam(':actor_id', $actor_id, PDO::PARAM_INT);
            $stmt->execute();
            
            // Set success message and redirect
            $_SESSION['success_message'] = "Actor information updated successfully";
            header("Location: actors.php");
            exit;
        } catch (PDOException $e) {
            $error_message = "Error updating actor: " . $e->getMessage();
        }
    }
}

// Get actor information
try {
    $stmt = $pdo->prepare("SELECT actor_id, first_name, last_name FROM actor WHERE actor_id = :actor_id");
    $stmt->bindParam(':actor_id', $actor_id, PDO::PARAM_INT);
    $stmt->execute();
    
    if ($stmt->rowCount() === 0) {
        $_SESSION['error_message'] = "Actor not found";
        header("Location: actors.php");
        exit;
    }
    
    $actor = $stmt->fetch();
} catch (PDOException $e) {
    $_SESSION['error_message'] = "Error retrieving actor information: " . $e->getMessage();
    header("Location: actors.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Actor - Sakila Database</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit Actor</h1>
    
    <div class="form-container">
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="actor_id">Actor ID:</label>
                <input type="text" id="actor_id" value="<?php echo htmlspecialchars($actor['actor_id']); ?>" disabled>
            </div>
            
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($actor['first_name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($actor['last_name']); ?>" required>
            </div>
            
            <div class="buttons">
                <button type="submit">Update Actor</button>
                <a href="actors.php" class="cancel-link">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>