<?php
/**
 * Test script to verify the database connection works with the new class-based approach
 */

// Get PDO connection from db_connection.php which now uses config.inc.php
$pdo = require_once 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Test</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Database Connection Test</h1>

    <?php
    try {
        // Test the connection by running a simple query
        $stmt = $pdo->query("SELECT 'Connection successful!' as message");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<p class='connection-success'>{$result['message']}</p>";
        echo "<p>Database connection is working correctly using configuration from config.inc.php.</p>";
        
        // Display connection information
        echo "<h2>Connection Information:</h2>";
        echo "<ul>";
        echo "<li>Driver: " . $pdo->getAttribute(PDO::ATTR_DRIVER_NAME) . "</li>";
        echo "<li>Server Version: " . $pdo->getAttribute(PDO::ATTR_SERVER_VERSION) . "</li>";
        echo "<li>Client Version: " . $pdo->getAttribute(PDO::ATTR_CLIENT_VERSION) . "</li>";
        echo "<li>Connection Status: " . $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "</li>";
        echo "</ul>";
        
    } catch (PDOException $e) {
        echo "<p class='connection-error'>Connection failed: " . $e->getMessage() . "</p>";
    }
    ?>
</body>
</html>